<form action="<?= site_url('nps_cadastrar') ?>" data-course-id="<?= html_escape($id) ?>" data-embedded="<?= !empty($embedded) ? '1' : '0' ?>" method="POST" autocomplete="off" id="form" >

						<?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"><?php endif; ?>
<input type="hidden" name="courseid" id="courseid" value="<?=html_escape($id);?>">
						
						<div class="col-12">
							<label for="email"><span class='obr'>*&nbsp;</span>E-mail</label>
							<input type="email" class="form-control" placeholder="Informe seu e-mail" name="email" id="email" required>
						</div>
						
						
						<div class="form-group" style="padding:10px;">
							<label for="escala"><span class='obr'>*&nbsp;</span>Em uma escala de 0 a 10, o quanto você recomendaria este evento a um colega farmacêutico?</label>
							<br>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala0" value="0"  required>
								<label class="form-check-label" for="escala0"><b>0</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala1" value="1"   required>
								<label class="form-check-label" for="escala1"><b>1</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala2" value="2"   required>
								<label class="form-check-label" for="escala2"><b>2</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala3" value="3"   required>
								<label class="form-check-label" for="escala3"><b>3</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala4" value="4"   required>
								<label class="form-check-label" for="escala4"><b>4</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala5" value="5"   required>
								<label class="form-check-label" for="escala5"><b>5</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala6" value="6"   required>
								<label class="form-check-label" for="escala6"><b>6</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala7" value="7"   required>
								<label class="form-check-label" for="escala7"><b>7</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala8" value="8"   required>
								<label class="form-check-label" for="escala8"><b>8</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala9" value="9"   required>
								<label class="form-check-label" for="escala9"><b>9</b></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="escala" id="escala10" value="10"   required>
								<label class="form-check-label" for="escala10"><b>10</b></label>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<label for="perguntaA"><span class='obr'>*&nbsp;</span>Qual foi o principal motivo da nota atribuída acima?</label>
									<input type="text" class="form-control" name="perguntaA" id="perguntaA" required>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<label for="perguntaB"><span class='obr'>*&nbsp;</span>O que mais te agradou no evento?</label>
									<input type="text" class="form-control" name="perguntaB" id="perguntaB" required>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<label for="perguntaC"><span class='obr'>*&nbsp;</span>Há algo que poderia ser melhorado em futuras edições?</label>
									<textarea class="form-control" name="perguntaC" id="perguntaC" rows="3" required></textarea>
								</div>
							</div>
						</div>
						
						<div class="form-group" style="padding:10px;">
							<label for="perguntaD"><span class='obr'>*&nbsp;</span>Você gostaria de participar de eventos semelhantes no futuro?</label>
							<br>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="perguntaD" id="perguntaD1" value="sim" required>
								<label class="form-check-label" for="perguntaD1"><b>SIM</b></label>
							</div>
							<br>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="perguntaD" id="perguntaD2" value="não"   required>
								<label class="form-check-label" for="perguntaD2"><b>NÃO</b></label>
							</div>
							<br>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="perguntaD" id="perguntaD3" value="talvez" required>
								<label class="form-check-label" for="perguntaD3"><b>Talvez</b></label>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<label for="perguntaE">Deseja deixar algum comentário adicional?</label>
									<textarea class="form-control" name="perguntaE" id="perguntaE" rows="3"></textarea>
								</div>
							</div>
						</div>

						<div class="form-group text-center">
							<button type="submit" class="btn" id="btn-send" style="background: #00598D; color: #FFF; border: none; padding: 10px 20px; border-radius: 10px; margin-top:10px;">RESPONDER</button>
						</div>
					</form>
<p id="nps-feedback" role="status" aria-live="polite"></p>
<script src="<?= base_url('assets/js/pesquisa-form.js') ?>" defer></script>
