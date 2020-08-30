<h1>Личный кабинет</h1>
<p>
	<table>
		<tr>
			<td>Фамилия</td>
			<td><?=$data['lastname']?></td>
		</tr>
		<tr>
			<td>Имя</td>
			<td><?=$data['firstname']?></td>
		</tr>
		<tr>
			<td>Отчество</td>
			<td><?=$data['secondname']?></td>
		</tr>
		<tr>
			<td>Логин</td>
			<td><?=$data['login']?></td>
		</tr>
	</table>
</p>
<a href="/edit/">Редактировать</a>