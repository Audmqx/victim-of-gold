<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<main id="main" class="site-main">
    <section class="error-404">
        <div class="error-404-container">
            <div class="error-404-content">
                <h1 class="error-404-title">404</h1>
                <h2 class="error-404-subtitle">Page non trouvée</h2>
                <p class="error-404-description">
                    Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
                </p>
                <div class="error-404-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        Retour à l'accueil
                    </a>
                    <a href="<?php echo esc_url(home_url('/boutique')); ?>" class="btn btn-secondary">
                        Voir la boutique
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.error-404 {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.error-404-container {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
    padding: 0 1rem;
}

.error-404-title {
    font-size: 8rem;
    font-weight: bold;
    color: #957B4D;
    margin: 0;
    line-height: 1;
}

.error-404-subtitle {
    font-size: 2rem;
    color: #333;
    margin: 1rem 0;
}

.error-404-description {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.error-404-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #957B4D;
    color: white;
}

.btn-primary:hover {
    background-color: #7a653f;
    color: white;
}

.btn-secondary {
    background-color: transparent;
    color: #957B4D;
    border: 2px solid #957B4D;
}

.btn-secondary:hover {
    background-color: #957B4D;
    color: white;
}

@media (max-width: 768px) {
    .error-404-title {
        font-size: 6rem;
    }
    
    .error-404-subtitle {
        font-size: 1.5rem;
    }
    
    .error-404-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 200px;
    }
}
</style>

<?php get_footer(); ?>
