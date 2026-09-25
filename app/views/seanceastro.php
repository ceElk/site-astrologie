<style>
.seance-wrapper {
    max-width: 900px;
    margin: 50px auto;
    padding: 0 20px;
}

.seance-header {
    text-align: center;
    margin-bottom: 40px;
}

.seance-header h1 {
    color: #c8a96e;
    font-family: Georgia, serif;
    letter-spacing: 3px;
    font-size: 28px;
    margin-bottom: 10px;
}

.seance-header p {
    color: #aaaacc;
    font-style: italic;
    font-size: 15px;
}

.cards-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    margin-bottom: 50px;
}

.seance-card {
    background: linear-gradient(135deg, rgba(10,31,58,0.92), rgba(6,20,43,0.92));
    border: 1px solid rgba(200,169,110,0.35);
    border-radius: 16px;
    padding: 30px 25px;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.seance-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(200,169,110,0.15);
}

.seance-card .icone {
    font-size: 40px;
    margin-bottom: 15px;
}

.seance-card h2 {
    color: #c8a96e;
    font-family: Georgia, serif;
    font-size: 17px;
    letter-spacing: 1px;
    margin-bottom: 12px;
    border-bottom: 1px solid rgba(200,169,110,0.2);
    padding-bottom: 12px;
}

.seance-card p {
    color: #aaaacc;
    font-size: 14px;
    font-family: Georgia, serif;
    line-height: 1.7;
    margin-bottom: 20px;
}

.seance-card .prix {
    color: #c8a96e;
    font-size: 20px;
    font-family: Georgia, serif;
    font-weight: bold;
    margin-bottom: 20px;
}

.btn-seance {
    background: linear-gradient(135deg, #c8a96e, #a07840);
    color: #020b18;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    letter-spacing: 1px;
    padding: 10px 20px;
    font-family: Georgia, serif;
    font-size: 13px;
    text-decoration: none;
    display: inline-block;
    transition: opacity 0.2s;
}

.btn-seance:hover {
    opacity: 0.85;
    color: #020b18;
}

.rdv-section {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    margin-top: 20px;
}

.rdv-image {
    flex: 1;
}

.rdv-image img {
    width: 100%;
    border-radius: 16px;
    border: 1px solid rgba(200,169,110,0.3);
    box-shadow: 0 8px 30px rgba(200,169,110,0.15);
}

.rdv-carte {
    flex: 2;
    background: linear-gradient(135deg, rgba(10,31,58,0.92), rgba(6,20,43,0.92));
    border: 1px solid rgba(200,169,110,0.35);
    border-radius: 16px;
    padding: 40px;
}

.rdv-carte h2 {
    color: #c8a96e;
    font-family: Georgia, serif;
    letter-spacing: 2px;
    font-size: 20px;
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 1px solid rgba(200,169,110,0.2);
    padding-bottom: 15px;
}

.rdv-carte .form-label {
    color: #c8a96e;
    font-family: Georgia, serif;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.rdv-carte .form-control,
.rdv-carte .form-select {
    background: rgba(2,11,24,0.8);
    border: 1px solid rgba(200,169,110,0.3);
    color: #e0e0ff;
    border-radius: 8px;
}

.rdv-carte .form-control:focus,
.rdv-carte .form-select:focus {
    background: rgba(2,11,24,0.9);
    border-color: #c8a96e;
    color: #e0e0ff;
    box-shadow: 0 0 8px rgba(200,169,110,0.3);
}

.rdv-carte .form-control::placeholder {
    color: #555577;
}

.rdv-carte .form-select option {
    background: #06142b;
    color: #e0e0ff;
}

.btn-rdv {
    background: linear-gradient(135deg, #c8a96e, #a07840);
    color: #020b18;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    letter-spacing: 1px;
    padding: 12px;
    font-family: Georgia, serif;
    width: 100%;
    margin-top: 10px;
    transition: opacity 0.2s;
}

.btn-rdv:hover {
    opacity: 0.85;
}

@media (max-width: 768px) {
    .rdv-section {
        flex-direction: column;
    }
}
</style>

<!-- BACKGROUND IMAGE -->
<div style="background-image:url('images/image5.jpg');
            background-size:cover;
            background-position:center;
            background-attachment:fixed;
            min-height:100vh">

<?php if (!empty($succes)): ?>
<div style="max-width:900px;margin:20px auto;
            background:rgba(0,200,100,0.1);
            border:1px solid rgba(0,200,100,0.3);
            border-radius:8px;padding:15px;
            text-align:center;color:#00cc66;
            font-family:Georgia,serif">
    ✦ Votre demande a bien été envoyée, je vous répondrai dans les plus brefs délais !
</div>
<?php endif; ?>

<?php if (!empty($erreur)): ?>
<div style="max-width:900px;margin:20px auto;
            background:rgba(255,0,0,0.1);
            border:1px solid rgba(255,0,0,0.3);
            border-radius:8px;padding:15px;
            text-align:center;color:#ff4444;
            font-family:Georgia,serif">
    ✦ Erreur d'envoi : <?= htmlspecialchars($erreur) ?>
</div>
<?php endif; ?>

<div class="seance-wrapper">

<div class="seance-header">
    <div style="background:rgba(0,0,0,0.6);
                border:1px solid rgba(200,169,110,0.3);
                border-radius:12px;
                padding:20px 30px;
                display:inline-block">
        <h1>✦ Séances Astrologiques ✦</h1>
        <p>Choisissez la séance qui correspond à votre besoin et réservez votre rendez-vous</p>
    </div>
</div>

    <!-- Cards séances -->
    <div class="cards-wrapper">

        <div class="seance-card">
            <div class="icone">☉</div>
            <h2>Thème Astral Natal</h2>
            <p>Exploration complète de votre thème de naissance. Comprendre vos forces, vos défis karmiques et votre chemin de vie à travers les astres.</p>
            <div class="prix">90 €</div>
            <a href="#rdv" class="btn-seance">✦ Réserver</a>
        </div>

        <div class="seance-card">
            <div class="icone">☀</div>
            <h2>Révolution Solaire</h2>
            <p>Analyse de votre année à venir à partir de votre anniversaire solaire. Quelles énergies vous accompagneront durant les 12 prochains mois ?</p>
            <div class="prix">75 €</div>
            <a href="#rdv" class="btn-seance">✦ Réserver</a>
        </div>

        <div class="seance-card">
            <div class="icone">♀♂</div>
            <h2>Synastrie de Thème</h2>
            <p>Analyse de la compatibilité entre deux thèmes astraux. Comprendre la dynamique d'une relation amoureuse, familiale ou professionnelle.</p>
            <div class="prix">110 €</div>
            <a href="#rdv" class="btn-seance">✦ Réserver</a>
        </div>

    </div>

    <!-- Image + Formulaire RDV côte à côte -->
    <div class="rdv-section" id="rdv">

        <!-- Image -->
        <div class="rdv-image">
            <img src="images/Capricorne-Karma-and-Love.png"
                 alt="Capricorne Karma and Love">
        </div>

        <!-- Formulaire -->
        <div class="rdv-carte">
            <h2>✦ Prendre Rendez-vous ✦</h2>
            <form method="POST" action="index.php?page=seance">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">✦ Prénom et Nom</label>
                        <input type="text" class="form-control" name="nom"
                               placeholder="Votre nom complet">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">✦ Email</label>
                        <input type="email" class="form-control" name="email"
                               placeholder="votre@email.com">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">✦ Téléphone</label>
                        <input type="tel" class="form-control" name="telephone"
                               placeholder="06 00 00 00 00">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">✦ Type de séance</label>
                        <select class="form-select" name="seance">
                            <option value="">Choisir une séance...</option>
                            <option value="theme">Thème Astral Natal — 90 €</option>
                            <option value="revolution">Révolution Solaire — 75 €</option>
                            <option value="synastrie">Synastrie de Thème — 110 €</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">✦ Objet</label>
                        <input type="text" class="form-control" name="objet"
                               placeholder="Ex : Demande de renseignements...">
                    </div>

                    <div class="col-12">
                        <label class="form-label">✦ Message</label>
                        <textarea class="form-control" name="message" rows="4"
                                  placeholder="Partagez ce qui vous amène, vos questions ou intentions..."></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn-rdv">
                            ✦ Envoyer ma demande de rendez-vous
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>

</div> <!-- fin seance-wrapper -->
</div> <!-- fin background -->