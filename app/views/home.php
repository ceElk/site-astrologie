<div style="position:relative;min-height:100vh;
            display:flex;align-items:center;justify-content:center">

    <!-- IMAGE FLOUTÉE EN ARRIÈRE-PLAN -->
    <div style="position:absolute;top:0;left:0;width:100%;height:100%;
                background-image:url('images/image5.jpg');
                background-size:cover;
                background-position:center;
               filter:blur(2px);
                transform:scale(1.05);">
    </div>

    <!-- OVERLAY SOMBRE -->
    <div style="position:absolute;top:0;left:0;width:100%;height:100%;
                background:rgba(2,11,24,0.5);">
    </div>

    <!-- CONTENU PAR-DESSUS -->
    <div class="container text-center" style="position:relative;z-index:1">

        <div style="background:rgba(0,0,0,0.6);
                    border:1px solid rgba(200,169,110,0.3);
                    border-radius:12px;
                    padding:40px 50px;
                    display:inline-block;
                    max-width:600px">

            <h1 style="color:#c8a96e;font-family:Georgia,serif;letter-spacing:3px">
                ✦ Bienvenue sur Karma & Love ✦
            </h1>
            <p style="color:#aaaacc;max-width:500px;margin:20px auto">
                Découvrez les secrets de votre thème natal et votre destinée, avec l'astrologie en mémoire cellulaire
            </p>

            <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;margin-top:30px">

                <a href="index.php?page=theme"
                   style="background:linear-gradient(135deg,#c8a96e,#a07840);
                          color:#020b18;font-weight:bold;border-radius:8px;
                          letter-spacing:1px;padding:12px 25px;
                          text-decoration:none;font-family:Georgia,serif">
                    ✦ Générer mon thème astral
                </a>

                <a href="index.php?page=seance"
                   style="background:linear-gradient(135deg,#c8a96e,#a07840);
                          color:#020b18;font-weight:bold;border-radius:8px;
                          letter-spacing:1px;padding:12px 25px;
                          text-decoration:none;font-family:Georgia,serif">
                    ✦ Prendre rendez-vous
                </a>

                <a href="index.php?page=apropos"
                   style="background:transparent;
                          color:#c8a96e;font-weight:bold;border-radius:8px;
                          letter-spacing:1px;padding:12px 25px;
                          text-decoration:none;font-family:Georgia,serif;
                          border:1px solid rgba(200,169,110,0.5)">
                    ✦ Qui suis-je
                </a>

            </div>
        </div>
    </div>
</div>