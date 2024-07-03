<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Sicepat Payung Sekaki</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kurir">Kurir</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pengantaran">Pengantaran</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/bukti">Bukti</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if(session()->get('isLoggedIn')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
