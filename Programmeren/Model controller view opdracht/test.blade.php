
<h1>Versturen van data naar Database</h1>

{{-- via de action /form/php/test gaat naar de web.php (routes) en stuurt het vanaf door naar de homecontroller --}}
<form class="" action="/form/php/test" method="POST" target="_blank">
{{ csrf_field() }}
<h2>Name:</h2><input style="border-style: outset;" type="text" size="40" name="name"  value=""><br><br>
<button type="submit" class="w3-button w3-black">Verstuur Name naar Database</button>
</form>

<h1>Gegevens van database</h1>

<table style="font-size:20px;">
<th>Names</th>

<tbody>
  {{-- hier maak ik een foreach met de variable die net is aangemaakt in de controller met alle gegevens van het model bezoeker
   en zet dit in een tabel zodat alle namen worden weergegeven --}}
@foreach ($names as $names)
  <tr>
      <td>{{$names->name}}</td>
  </tr>
@endforeach
</tbody>
</table>


<style>
table, td, th {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
width:25%;
}

td{
  text-align:center;
}

th {
  height: 50px;
}
</style>
