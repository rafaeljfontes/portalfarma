<style>
.docs-page{padding:55px 20px 80px;background:#f7f9fb;min-height:65vh}.docs-wrap{max-width:1180px;margin:auto}
.docs-title{font-size:41px;color:#e92d26;font-weight:700;max-width:680px;line-height:1.25;margin:0 0 30px}
.btn-voltar{display:inline-flex;align-items:center;gap:8px;margin-bottom:52px;padding:9px 20px;border-radius:10px;background:#ffffff00;border:1px solid #12455e;color:#12455e;font-size:17px;font-weight:700;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,.06);transition:background-color .25s ease,color .25s ease,border-color .25s ease,box-shadow .25s ease}
.btn-voltar:hover{background:#0b4f63;color:#fff;border-color:#0b4f63;box-shadow:0 10px 24px #0b4e6313}
.docs-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:38px 28px}
.doc-card{display:block;color:#25364a;text-decoration:none}.doc-cover{position:relative;aspect-ratio:3/4;overflow:hidden;background:#e8edf1;box-shadow:0 8px 22px rgba(0,0,0,.13)}
.doc-cover img{width:100%;height:100%;object-fit:cover;transition:transform .45s ease,filter .45s ease}.doc-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(8,76,98,.72);color:#fff;font-weight:700;letter-spacing:.04em;opacity:0;transition:opacity .35s}
.doc-card:hover .doc-cover img{transform:scale(1.08);filter:brightness(.75)}.doc-card:hover .doc-overlay{opacity:1}
.doc-meta{padding:17px 2px 0}.doc-name{font-size:16px;font-weight:700;line-height:1.4;margin:0;color:#163b59;letter-spacing:.01em;transition:color .25s ease}
.doc-card:hover .doc-name{color:#e94b35}.doc-date{display:inline-flex;align-items:center;gap:7px;margin-top:11px;padding:6px 10px;border-radius:20px;background:#edf4f7;color:#526978;font-size:12px;font-weight:600}
.doc-date i{color:#e94b35;font-size:13px}.docs-empty{text-align:center;color:#6b7280;padding:60px}
</style>
<main class="docs-page"><div class="docs-wrap">
  <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>
  <h1 class="docs-title">Documentos técnicos</h1>
  <?php if (empty($documentos)): ?><div class="docs-empty">Nenhum documento técnico publicado.</div><?php else: ?>
  <div class="docs-grid"><?php foreach ($documentos as $doc): ?>
    <a class="doc-card" href="<?=base_url('doc_tecnico/abrir/'.$doc->id)?>" target="_blank" rel="noopener">
      <div class="doc-cover"><img src="<?=base_url('uploads/doc_tecnico/'.$doc->capa)?>" alt="<?=html_escape($doc->titulo)?>"><span class="doc-overlay">ABRIR DOCUMENTO</span></div>
      <div class="doc-meta">
        <h2 class="doc-name"><?=html_escape($doc->titulo)?></h2>
        <div class="doc-date"><i class="bi bi-calendar3"></i><span>Cadastrado em <?=date('d/m/Y',strtotime($doc->data_criacao))?></span></div>
      </div>
    </a>
  <?php endforeach; ?></div><?php endif; ?>
</div></main>
