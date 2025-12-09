document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const sidebar = document.querySelector('.sidebar');

    if (!hamburger || !sidebar) return;

    let overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0,0,0,0.3)';
    overlay.style.zIndex = '1';
    overlay.style.opacity = '0';
    overlay.style.visibility = 'hidden';
    overlay.style.transition = 'opacity 0.3s ease';
    document.body.appendChild(overlay);

    function abrirSidebar() {
        sidebar.classList.add('open');
        overlay.style.opacity = '1';
        overlay.style.visibility = 'visible';
        document.body.classList.add('sidebar-open');
        document.body.style.overflow = 'hidden';
    }

    function fecharSidebar() {
        sidebar.classList.remove('open');
        overlay.style.opacity = '0';
        overlay.style.visibility = 'hidden';
        document.body.classList.remove('sidebar-open');
        document.body.style.overflow = '';
    }

    function toggleSidebar() {
        if (sidebar.classList.contains('open')) {
            fecharSidebar();
        } else {
            abrirSidebar();
        }
    }

    hamburger.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', fecharSidebar);

    sidebar.addEventListener('click', function(e){
        if(e.target.closest('a')) fecharSidebar();
    });

    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape') fecharSidebar();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.querySelector('.btn-logout');

    if (logoutButton) {
        logoutButton.addEventListener('click', function (e) {
            e.preventDefault();
            const confirmar = confirm('Você realmente quer sair?');
            if (confirmar) {
                window.location.href = logoutButton.href;
            }
        });
    }
});

