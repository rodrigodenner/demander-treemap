document.addEventListener('DOMContentLoaded', function() {
  const elementos = getCountryElements(countryData);
  renderTreemap(elementos);
  setupModal();
  displayTotalCases(countryData.total_cases);
});

function displayTotalCases(totalCases) {
  const totalCasesElement = document.getElementById('total-cases');
  totalCasesElement.textContent = `Total de Casos Registrados na América do Sul: ${formatNumber(totalCases)}`;
}

function getCountryElements(data) {
  return Object.values(data)
    .filter(country => country.percentage !== undefined)
    .map(country => ({
      name: country.name,
      cases: country.cases,
      recovered: country.recovered,
      deaths: country.deaths,
      flag: country.flag,
      percentage: country.percentage
    }))
    .sort((a, b) => b.percentage - a.percentage);
}

function renderTreemap(elementos) {
  const container = document.getElementById('treemap-container');
  const { numCols, numRows, totalArea } = calculateGridDimensions(elementos.length);

  container.style.gridTemplateColumns = `repeat(${numCols}, 1fr)`;
  container.style.gridTemplateRows = `repeat(${numRows}, 1fr)`;

  elementos.forEach(elemento => {
    const { columnsToSpan, rowsToSpan } = calculateSpan(elemento.percentage, totalArea);
    const box = createBoxElement(elemento, columnsToSpan, rowsToSpan);
    container.appendChild(box);
  });
}

function formatNumber(num) {
  return num.toLocaleString('pt-BR');
}

function calculateGridDimensions(count) {
  const numCols = Math.ceil(Math.sqrt(count));
  const numRows = Math.ceil(count / numCols);
  const totalArea = numCols * numRows;
  console.log(`Number of columns: ${numCols}, Number of rows: ${numRows}`);
  return { numCols, numRows, totalArea };
}

function calculateSpan(percentage, totalArea) {
  const cellsToSpan = Math.round((percentage / 100) * totalArea);
  const columnsToSpan = Math.max(1, Math.round(Math.sqrt(cellsToSpan)));
  const rowsToSpan = Math.max(1, Math.ceil(cellsToSpan / columnsToSpan));
  return { columnsToSpan, rowsToSpan };
}

function getColor(percentage) {
  if (percentage <= 1) return '#FFA500';
  if (percentage <= 6) return '#0000FF';
  if (percentage <= 30) return '#32CD32';
  if (percentage > 50) return '#004d00';
  return '#FF0000';
}

function createBoxElement(elemento, columnsToSpan, rowsToSpan) {
  const box = document.createElement('div');
  box.className = 'box';
  box.style.gridColumn = `span ${columnsToSpan}`;
  box.style.gridRow = `span ${rowsToSpan}`;
  box.style.backgroundColor = getColor(elemento.percentage);

  if (elemento.percentage <= 1) {
    box.style.color = 'black';
  } else {
    box.style.color = 'white';
  }

  const percentage = document.createElement('div');
  percentage.className = 'percentage';
  percentage.textContent = `${elemento.percentage.toFixed(2)}%`;
  box.appendChild(percentage);

  const name = document.createElement('div');
  name.className = 'name';
  name.textContent = elemento.name;
  box.appendChild(name);

  box.addEventListener('click', function() {
    openModal(elemento);
  });

  return box;
}

function openModal(elemento) {
  const modal = document.getElementById('modal');
  document.getElementById('modal-flag').src = elemento.flag;
  document.getElementById('modal-name').textContent = elemento.name;
  document.getElementById('modal-cases').textContent = `CASOS REGISTRADOS: ${formatNumber(elemento.cases)}`;
  document.getElementById('modal-recovered').textContent = `RECUPERADOS: ${formatNumber(elemento.recovered)}`;
  document.getElementById('modal-deaths').textContent = `ÓBITOS REGISTRADOS: ${formatNumber(elemento.deaths)}`;
  modal.style.display = 'block';
}

function setupModal() {
  const modal = document.getElementById('modal');
  const closeButton = document.querySelector('.modal .close');

  closeButton.onclick = function() {
    modal.style.display = 'none';
  };

  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  };
}
