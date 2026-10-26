<div class="container py-4">
 <div class="d-flex justify-content-between align-items-center mb-3"><h3>Documentos técnicos</h3><a class="btn btn-primary" href="<?=base_url('restrito/doc_tecnico/criar')?>">+ Novo documento</a></div>
 <?php if($this->session->flashdata('doc_sucesso')):?><div class="alert alert-success"><?=$this->session->flashdata('doc_sucesso')?></div><?php endif;?>
 <div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>ID</th><th>Título</th><th>Data de criação</th><th>Acessos</th><th>Ações</th></tr></thead><tbody>
 <?php if(empty($documentos)):?><tr><td colspan="5" class="text-center py-4">Nenhum documento cadastrado.</td></tr><?php else: foreach($documentos as $doc):?>
 <tr><td><?=intval($doc->id)?></td><td><?=html_escape($doc->titulo)?></td><td><?=date('d/m/Y H:i',strtotime($doc->data_criacao))?></td><td><span class="badge bg-info text-dark"><?=intval($doc->acesso)?></span></td>
 <td><a class="btn btn-sm btn-warning" href="<?=base_url('restrito/doc_tecnico/editar/'.$doc->id)?>">Editar</a> <a class="btn btn-sm btn-danger" onclick="return confirm('Excluir este documento definitivamente?')" href="<?=base_url('restrito/doc_tecnico/excluir/'.$doc->id)?>">Excluir</a></td></tr>
 <?php endforeach; endif;?></tbody></table></div></div>
</div>
