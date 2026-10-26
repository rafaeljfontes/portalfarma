<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Acesso negado</title>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<script>
		Swal.fire({
			icon: 'error',
			title: 'Acesso negado',
			text: 'Sem permissão para acessar esta página',
			confirmButtonText: 'OK',
			allowOutsideClick: false,
			allowEscapeKey: false
		}).then(function () {
			window.location.href = <?=json_encode(base_url('restrito/inicio'))?>;
		});
	</script>
</body>
</html>
