
// TODO: use webpack for transpiling, bundling, minification.
// TODO: use es6 classes to organize into multiple files instead of one monolith.
// TOOD: encapsulate axios in an api service.
// TODO: convert Auth object to a VUEX object.
// TODO: convert Employees object to a VUEX object.

(function() {

    Vue.prototype.$http = axios

    const get = (prop, ...props) => obj =>
        obj == null || prop == null
            ? obj
            : get(...props)(obj[prop])

    const Auth = {
        authenticated: false,
        username: null,
        login: function(username) {
            Auth.authenticated = true
            Auth.username = username
        },
        logout: function() {
            Auth.authenticated = false
            Auth.username = null
        }
    }

    const Employees = {
        items: [],
        setEmployees: function(employees) {
            this.items.map((x, i) => Vue.delete(i))
            employees.map((x, i) => {
                Vue.set(Employees.items, i, x)
            })
        }
    }

    // 1. Define route components.
    // These can be imported from other files
    const List = {
        template: `
            <div>
                <h2>Employee List</h2>

                <table v-if="loaded" class="table table-striped table-hover table-employee">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>birthdate</th>
                            <th>address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in employees" v-on:click="edit(employee)">
                            <td>{{ employee.id }}</td>
                            <td>{{ employee.name }}</td>
                            <td>{{ employee.email }}</td>
                            <td>{{ employee.date_of_birth }}</td>
                            <td>
                                <div>{{ employee.address1 }}</div>
                                <div>{{ employee.address2 }}</div>
                                <div>{{ employee.city }}, {{ employee.state }} {{ employee.zip }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>`,
        data: function() {
            return {
                loaded: false,
                employees: Employees.items
            }
        },
        methods: {
            edit: function(employee) {
                this.$router.push(`/employee/${employee.id}`)
            }
        },
        mounted: function() {
            this.$http.get('/api/employees')
                .then(response => {
                    this.loaded = true
                    Employees.setEmployees(response.data.employees)
                })
        }
    }
    const EmployeeEdit = {
        template: `
            <h2>{{ employee.name }}</h2>`,
        data: function() {
            return {
                employee: {}
            }
        }
    }
    const Login = {
        template: `
            <div>
                <h2>Login</h2>
                <div class="form-group">
                    <label for="username">Email address</label>
                    <input v-model="username" type="email" class="form-control" id="username" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input v-model="password" type="password" class="form-control" id="username" placeholder="Password">
                </div>

                <div>
                    <button v-on:click="login" class="btn btn-primary">login</button>
                </div>

                <div v-html="error" v-if="error" class="bg-danger errors"></div>
            </div>`,
        data: function() {
            return {
                username: '',
                password: '',
                error: '',
            }
        },
        methods: {
            login: function (event) {
                const $router = this.$router
                this.error = ''
                this.$http.post('/api/user/login', {
                        username: this.username,
                        password: this.password
                    })
                    .then(response => {
                        Auth.login(response.data.username)
                        console.log('push to /')
                        setTimeout(function() {
                            $router.push('/')
                        }, 0);
                    })
                    .catch(err => {
                        this.error = Object.keys(err.response.data)
                            .map(key => `${key}: ${err.response.data[key]}`)
                            .join('<br/>')
                    })
            }
        },
        mounted: function() {
            Auth.logout()
        }
    }
    const Logout = {
        template: '<div>logging out...</div>',
        mounted: function() {
            this.$http.post('/api/user/logout')
                .then(response => {
                    Auth.logout()
                    this.$router.push('/')
                })
        }
    }

    // 2. Define some routes
    // Each route should map to a component. The "component" can
    // either be an actual component constructor created via
    // Vue.extend(), or just a component options object.
    // We'll talk about nested routes later.
    const routes = [
        { path: '/', component: List, props: { auth: true } },
        { path: '/employee/:id', component: EmployeeEdit, props: { auth: true } },
        { path: '/login', component: Login },
        { path: '/logout', component: Logout },
    ]

    // 3. Create the router instance and pass the `routes` option
    // You can pass in additional options here, but let's
    // keep it simple for now.
    const router = new VueRouter({
        routes // short for routes: routes
    })
    router.beforeEach((to, from, next) => {
        const requireAuth = get('matched', '0', 'props', 'default', 'auth')(to) || false

        return next(requireAuth && !Auth.authenticated ? '/login': next)
    })

    // 4. Create and mount the root instance.
    // Make sure to inject the router with the router option to make the
    // whole app router-aware.
    const app = new Vue({
        data: {
            auth: Auth
        },
        router
    }).$mount('#app')

    app.$http.post('/api/user/check')
        .then(response => {
            Auth.authenticated = response.data.authenticated
            Auth.username = response.data.username
        })

    // Now the app has started!
}());
