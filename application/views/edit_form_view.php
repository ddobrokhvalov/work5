<h1>Регистрация</h1>
<p>
	<form method="POST" class="user_form">
		<table>
			<tr>
				<td>Логин</td>
				<td><input type="text" name="login" class="required" value="<?=$data[0]['login']?>"></td>
			</tr>
			<tr>
				<td>Пароль</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td>Повторите пароль</td>
				<td><input type="password" name="repassword"></td>
			</tr>
			<tr>
				<td>Фамилия</td>
				<td><input type="text" name="lastname" class="required" value="<?=$data[0]['lastname']?>"></td>
			</tr>
			<tr>
				<td>Имя</td>
				<td><input type="text" name="firstname" class="required" value="<?=$data[0]['firstname']?>"></td>
			</tr>
			<tr>
				<td>Отчество</td>
				<td><input type="text" name="secondname" class="required" value="<?=$data[0]['secondname']?>"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Сохранить"></td>
			</tr>
		</table>
<p class="error"><?=$data["error"]?></p>
</form>
</p>
<a href="/index.php">Назад</a>