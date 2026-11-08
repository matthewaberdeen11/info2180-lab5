const countryInput = document.getElementById('country');
const lookupButton = document.getElementById('lookup');
const result = document.getElementById('result');

lookupButton.addEventListener('click', async (event) => {
  event.preventDefault();

  const params = new URLSearchParams({ country: countryInput.value.trim() });

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
});