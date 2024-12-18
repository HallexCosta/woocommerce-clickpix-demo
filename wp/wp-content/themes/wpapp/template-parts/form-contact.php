<?php
  $form_id = isset($args['form_id']) ? $args['form_id'] : '';
?>

<form id="<?php echo $form_id; ?>" class="contact-form <?php echo $form_id; ?>">
	<div class="form-header">
		<h1>Preencha o formulário e entraremos em contato em breve.</h1>
	</div>

	<div class="form-content">
		<div class="input-box">
			<input name="name" id="name" type="text" placeholder="Nome"> 
			<span class="message-error hidden">* campo obrigatório</span>
		</div>

		<div class="input-box">
			<input name="email" id="email" type="email" placeholder="E-mail">
			<span class="message-error hidden">* campo obrigatório</span>
		</div>

		<div class="input-box">
			<input class="cellphone-mask" name="whatsapp" id="whatsapp" type="text" placeholder="Whatsapp">
			<span class="message-error hidden">* campo obrigatório</span>
		</div>

		<div class="input-box">
			<input class="cnpj-mask" name="cnpj" id="cnpj" type="text" placeholder="CNPJ">
			<span class="message-error hidden">* campo obrigatório</span>
		</div>

		<div class="input-box state">
			<select name="state" id="state">
				<option value="" selected disabled>Estado</option>
				<option value="São Paulo">São Paulo</option>
			</select>
			<span class="message-error hidden">* campo obrigatório</span>
		</div>


		<div class="input-box zipcode">
			<input class="zipcode-mask" name="zipcode" id="zipcode" type="text" placeholder="CEP">
			<span class="message-error hidden">* campo obrigatório</span>
		</div>

		<div class="input-box textarea">
			<textarea name="message" id="message" type="text" placeholder="Mensagem"></textarea>
			<span class="message-error hidden">* campo obrigatório</span>
		</div>

		<div class="input-box">
			<div class="terms-wrapper">
				<label class="checkbox" for="term">
					<input class="hidden" type="checkbox" name="term" id="term">
					<span class="checkmark"></span>
					<span class="text">Aceito os <a href="#" target="_blank">termos e condições</a> de uso dos meus dados </span>
					<span class="message-error hidden">* campo obrigatório</span>
				</label>
			</div>
		</div>
	</div>

	<div class="form-footer">  
			<div class="box-invisible-small"></div>
			<button id="btn-enviar" class="btn">Enviar</button>
	</div>
</form>