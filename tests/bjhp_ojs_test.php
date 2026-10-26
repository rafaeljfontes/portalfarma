<?php
define('BASEPATH', __DIR__);
require __DIR__ . '/../application/libraries/Bjhp_ojs.php';
require __DIR__ . '/../application/helpers/auxiliares_helper.php';

function check($condition, $message) { if (!$condition) throw new RuntimeException($message); }
class FakeOjs extends Bjhp_ojs
{
    public $responses = array();
    protected function request($path, $query = array())
    {
        $key = $path . ':' . ($query['offset'] ?? 'detail');
        if (!array_key_exists($key, $this->responses)) throw new RuntimeException('Unexpected request ' . $key);
        return $this->responses[$key];
    }
}
function rejects($callback) {
    try { $callback(); } catch (RuntimeException $e) { return; }
    throw new RuntimeException('Expected rejection');
}
$api = new FakeOjs(array('ojs_locale' => 'pt_BR'));
$api->responses = array(
    'contexts:detail' => array('items' => array(array('urlPath' => 'crfmg', 'currentIssueId' => 1))),
    'issues:0' => array('items' => array(array('id' => 1, 'title' => array('pt_BR' => 'Edição'), 'year' => 2026)), 'itemsMax' => 2),
    'issues:1' => array('items' => array(array('id' => 2, 'title' => array('en_US' => 'Issue'))), 'itemsMax' => 2),
    'submissions:0' => array('items' => array(array('id' => 10, 'currentPublicationId' => 20)), 'itemsMax' => 1),
    'submissions/10/publications/20:detail' => array('id' => 20, 'status' => 3, 'issueId' => 1, 'title' => array('pt_BR' => 'Artigo'), 'abstract' => array('en_US' => 'Abstract'))
);
$data = $api->fetch();
check($data['edicoes'][0]['currentIssueId'] === 1 && $data['edicoes'][1]['currentIssueId'] === 1, 'Current issue ID is preserved for every imported issue');
check($data['edicoes'][0]['edicao_atual'] === 1 && $data['edicoes'][1]['edicao_atual'] === 0, 'Current issue flag matches OJS ID');
check(count($data['edicoes']) === 2, 'Must fetch all pages even when server caps page size');
check($data['artigos'][0]['titulo'] === 'Artigo', 'Localized title');
check($data['edicoes'][1]['titulo'] === 'Issue', 'Locale fallback');
check($data['artigos'][0]['ojs_article_id'] === 10, 'Submission ID maps to ojs_article_id');
check($data['edicoes'][0]['ojs_issue_id'] === 1, 'Issue ID maps to ojs_issue_id');
check($data['artigos'][0]['edicao_ojs_id'] === 1, 'Issue association');
$api->responses['issues:1']['items'][0]['id'] = 1;
rejects(function () use ($api) { $api->fetch(); });
$api->responses['issues:1']['items'] = array();
rejects(function () use ($api) { $api->fetch(); });
$api->responses['issues:0'] = array('error' => 'invalid');
rejects(function () use ($api) { $api->fetch(); });
check(in_array('BJHP', portalfarma_permissoes('["BJHP"]'), true), 'JSON permission');
check(in_array('BJHP', portalfarma_permissoes('admin, BJHP'), true), 'CSV permission');
check(in_array('BJHP', portalfarma_permissoes('{"BJHP":true}'), true), 'Object permission');
check(!in_array('BJHP', portalfarma_permissoes('admin'), true), 'Admin must not imply BJHP');
check(!in_array('BJHP', portalfarma_permissoes('BJHP_extra'), true), 'Exact permission required');
echo "BJHP: pagination, mapping, malformed responses and permissions OK\n";
