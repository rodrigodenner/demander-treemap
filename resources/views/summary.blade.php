<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Covid-19 na América Latina</title>
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
<h1>Resumo Covid-19 na América Latina</h1>

<div id="treemap-container"></div>

<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <img id="modal-flag" src="" alt="Bandeira do país">
    <h2 id="modal-name"></h2>
    <p id="modal-cases"></p>
    <p id="modal-recovered"></p>
    <p id="modal-deaths"></p>
  </div>
</div>


<div class="legend">
  <div class="legend-item">
    <div class="color-box" style="background-color: #FFA500;"></div>
    <span>Até 1%</span>
  </div>
  <div class="legend-item">
    <div class="color-box" style="background-color: #0000FF;"></div>
    <span>1% a 6%</span>
  </div>
  <div class="legend-item">
    <div class="color-box" style="background-color: #32CD32;"></div>
    <span>6% a 30%</span>
  </div>
  <div class="legend-item">
    <div class="color-box" style="background-color: #228B22;"></div>
    <span>30% a 50%</span>
  </div>
  <div class="legend-item">
    <div class="color-box" style="background-color: #004d00;"></div>
    <span>Acima de 50%</span>
  </div>
</div>

<div id="total-cases" class="total-cases"></div>

  <p>Dados COVID-19 provenientes de Worldometers, atualizados a cada 10 minutos</p>

<script>
  var countryData = @json($countries);
</script>
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
