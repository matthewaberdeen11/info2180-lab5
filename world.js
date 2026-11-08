const countryInput = document.getElementById('country');
const result = document.getElementById('result');
const lookupButton = document.getElementById('lookup');
const citiesButton = document.getElementById('lookup-cities');

async function lookup(showCities) {
  const params = new URLSearchParams({ country: countryInput.value.trim() });

  if (showCities) {
    params.set('lookup', 'cities');
  }

  try {
    const response = await fetch(`world.php?${params}`);
    if (!response.ok) {
      throw new Error(`Request failed (${response.status})`);
    }
    result.innerHTML = await response.text();
  } catch (error) {
    result.textContent = 'Could not load the results.';
    console.error(error);
  }
}

lookupButton.addEventListener('click', () => lookup(false));
citiesButton.addEventListener('click', () => lookup(true));