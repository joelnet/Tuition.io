<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='/css/app.css' rel='stylesheet' type='text/css'>
        
        <script src="https://unpkg.com/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div id="app">
                <h1>Employee Manager</h1>

                <div v-if="auth.authenticated" class="welcome">
                    Welcome <span class="username">{{ auth.username }}</span> <router-link to="/logout">logout</router-link>
                </div>

                <p>
                    <!-- use router-link component for navigation. -->
                    <!-- specify the link by passing the `to` prop. -->
                    <!-- <router-link> will be rendered as an `<a>` tag by default -->
                    <router-link to="/">Employee List</router-link>
                </p>
                <!-- route outlet -->
                <!-- component matched by the route will render here -->
                <router-view></router-view>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
