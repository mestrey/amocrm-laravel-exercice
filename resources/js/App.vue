<template>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Сделки Fresh Cube</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" to="/">
                        Выбор сделки
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/link">
                        Привязка контакта
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/logs">
                        История
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
    <router-view />
</template>
