<style>
.form-astro {
    background: linear-gradient(135deg, #0a1f3a, #06142b);
    border: 1px solid rgba(200,169,110,0.4);
    border-radius: 16px;
    padding: 40px;
    max-width: 500px;
    margin: 50px auto;
}

.form-astro h1 {
    color: #c8a96e;
    font-family: Georgia, serif;
    letter-spacing: 3px;
    font-size: 22px;
    text-align: center;
    margin-bottom: 30px;
}

.form-astro .form-label {
    color: #c8a96e;
    font-family: Georgia, serif;
    letter-spacing: 1px;
    font-size: 14px;
}

.form-astro .form-control,
.form-astro .form-select {
    background-color: rgba(2,11,24,0.8);
    border: 1px solid rgba(200,169,110,0.3);
    color: #e0e0ff;
    border-radius: 8px;
}

.form-astro .form-control:focus,
.form-astro .form-select:focus {
    background-color: rgba(2,11,24,0.9);
    border-color: #c8a96e;
    color: #e0e0ff;
    box-shadow: 0 0 8px rgba(200,169,110,0.3);
}

.form-astro .form-select option {
    background: #06142b;
    color: #e0e0ff;
}

.form-astro .form-control::placeholder {
    color: #555577;
}

.btn-astro {
    background: linear-gradient(135deg, #c8a96e, #a07840);
    color: #020b18;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    letter-spacing: 1px;
    padding: 12px;
    font-family: Georgia, serif;
    transition: opacity 0.2s;
}

.btn-astro:hover {
    opacity: 0.85;
    color: #020b18;
}
</style>

<div class="form-astro">
    <h1>✦ Thème Astral ✦</h1>

    <form method="POST" action="index.php?page=theme-result">

        <div class="mb-3">
            <label class="form-label">✦ Date de naissance</label>
            <input type="date" class="form-control" name="date">
        </div>

        <div class="mb-3">
            <label class="form-label">✦ Heure de naissance</label>
            <input type="time" class="form-control" name="heure">
        </div>

        <div class="mb-3">
            <label class="form-label">✦ Lieu de naissance</label>
            <input type="text"
                   class="form-control"
                   name="ville"
                   placeholder="Ex : Paris">
        </div>

        <div class="mb-3">
            <label class="form-label" for="zodiac">✦ Zodiaque</label>
            <select class="form-select" name="zodiac" id="zodiac">
                <option value="tropical">Tropical</option>
                <option value="sidereal">Sidéral</option>
            </select>
        </div>

        <div class="mb-3" id="ayanamsa-group" style="display: none;">
            <label class="form-label" for="ayanamsa">✦ Ayanamsa</label>
            <select class="form-select" name="ayanamsa" id="ayanamsa">
                <option value="lahiri">Lahiri</option>
                <option value="fagan_bradley">Fagan-Bradley</option>
                <option value="krishnamurti">Krishnamurti</option>
                <option value="raman">Raman</option>
            </select>
        </div>

        <button class="btn btn-astro w-100 mt-3">
            ✦ Calculer mon thème astral
        </button>

    </form>
</div>

<script>
    const zodiacSelect  = document.getElementById('zodiac');
    const ayanamsaGroup = document.getElementById('ayanamsa-group');

    function toggleAyanamsa() {
        ayanamsaGroup.style.display = zodiacSelect.value === 'sidereal' ? 'block' : 'none';
    }

    zodiacSelect.addEventListener('change', toggleAyanamsa);
    toggleAyanamsa();
</script>
