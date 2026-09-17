<div class="msg-body" style="width: 100%; /*max-width: 600px;*/ margin: auto; box-sizing: border-box; padding: 20px; /* background: #1c1c1c; color: #fff;*/">
	<div class="txt" style="font-size: 13.5px; font-family: 'Arial', sans-seriff; margin-bottom: 20px;">Foi recebido o seguinte pedido de contacto:</div>
	<table>
		<tr>
			<td class="label" style="font-weight: 700; padding-right: 5px;/* color: #fff*;*/ font-size: 13px; font-family: 'Tahoma', sans-seriff;">Nome</td>
			<td class="value" style="/* color: #fff;*/ font-size: 14px; font-family: 'Arial', sans-seriff;"><?php 
				if (exists($data['name'])) {
					echo $data['name'];
				}
			?></td>
		</tr>
		<tr>
			<td class="label" style="font-weight: 700; padding-right: 5px; /* color: #fff;*/ font-size: 13px; font-family: 'Tahoma', sans-seriff;">Endereço de Correio Eletrónico</td>
			<td class="value" style="/* color: #fff;*/ font-size: 14px; font-family: 'Arial', sans-seriff;"><?php
				if (exists($data['from_email'])) {
					echo $data['from_email'];
				}
			?></td>
		</tr>
		<tr>
			<td class="label" style="font-weight: 700; padding-right: 5px;/*  color: #fff*/; font-size: 13px; font-family: 'Tahoma', sans-seriff;">Número de Telefone</td>
			<td class="value" style="/* color: #fff;*/ font-size: 14px; font-family: 'Arial', sans-seriff;"><?php 
			 	if (exists($data['contact_tel'])) {
					echo $data['contact_tel'];
				}
			?></td>
		</tr>
		<tr>
			<td class="label" style="font-weight: 700; padding-right: 5px;/*  color: #fff;*/ font-size: 13px; font-family: 'Tahoma', sans-seriff;">Mensagem</td>
			<td class="value" style="/* color: #fff;*/ font-size: 14px; font-family: 'Arial', sans-seriff;"><?php
				if (exists($data['contact_msg'])) {
					echo nl2br($data['contact_msg']);
				}
			?></td>
		</tr>
		
	</table>
</div>