<h1>Авторизация</h1>
<p>
	<form method="POST" class="user_form">
		<table>
			<tr>
				<td>Логин</td>
				<td><input type="text" name="login" class="required"></td>
			</tr>
			<tr>
				<td>Пароль</td>
				<td><input type="password" name="password" class="required"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Войти"></td>
			</tr>
		</table>
<p class="error"><?=$data["error"]?></p>
</form>
</p>
<a href="/register/">Регистрация</a>