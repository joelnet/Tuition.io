
// TODO: use webpack for transpiling, bundling, minification.
// TODO: use es6 classes to organize into multiple files instead of one monolith.
// TOOD: encapsulate axios in an api service.
// TODO: convert Auth object to a VUEX object.
// TODO: convert Employees object to a VUEX object.
// TODO: highlight field with error message.
// TODO: move error messages closer to the field with the errors.

(function() {

    Vue.prototype.$http = axios

    const get = (prop, ...props) => obj =>
        obj == null || prop == null
            ? obj
            : get(...props)(obj[prop])
    const propEq = (prop, val) => obj =>
        obj[prop] === val

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

                <div>
                    <router-link class="btn btn-primary" to="/employees/new">New Employee</router-link>
                </div>
            </div>`,
        data: function() {
            return {
                loaded: false,
                employees: []
            }
        },
        methods: {
            edit: function(employee) {
                this.$router.push(`/employees/${employee.id}`)
            }
        },
        mounted: function() {
            this.loaded = false
            this.$http.get('/api/employees')
                .then(response => {
                    this.loaded = true
                    this.employees = response.data.employees
                })
        }
    }
    const EmployeeNew = {
        template: `
            <div>
                <h2>New Employee</h2>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input v-model="employee.name" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input v-model="employee.email" type="email" class="form-control" id="email" placeholder="E-Mail">
                </div>
                <!-- TODO: use Date Picker -->
                <!-- TODO: strip time off date -->
                <div class="form-group">
                    <label for="date_of_birth">Birthdate</label>
                    <input v-model="employee.date_of_birth" class="form-control" id="date_of_birth" placeholder="Birthdate">
                </div>
                <div class="form-group">
                    <label for="address1">Address 1</label>
                    <input v-model="employee.address1" class="form-control" id="address1" placeholder="Address 1">
                </div>
                <div class="form-group">
                    <label for="address1">Address 2</label>
                    <input v-model="employee.address2" class="form-control" id="address2" placeholder="Address 2">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input v-model="employee.city" class="form-control" id="city" placeholder="City">
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input v-model="employee.state" class="form-control" id="state" placeholder="State">
                </div>
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input v-model="employee.postal_code" class="form-control" id="postal_code" placeholder="Postal Code">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input v-model="employee.country" class="form-control" id="country" placeholder="Country">
                </div>
                <div>
                    <button v-on:click="save" class="btn btn-primary">Save</button>
                    
                    <router-link to="/" class="btn btn-default">Close</router-link>
                </div>
                <div v-html="error" v-if="error" class="bg-danger errors"></div>
            </div>`,
        data: function() {
            return {
                employee: {},
                error: null
            }
        },
        methods: {
            save: function() {
                this.message = null
                this.error = null

                this.$http.post(`/api/employees`, this.employee)
                    .then(response => {
                        this.$router.push(`/`)
                    })
                    .catch(err => {
                        this.error = Object.keys(err.response.data)
                            .map(key => `${key}: ${err.response.data[key]}`)
                            .join('<br/>')
                    })
            }
        }
    }
    const EmployeeEdit = {
        template: `
            <div>
                <div v-if="!employee">
                    loading...
                </div>
                <div v-if="employee">
                    <h2>Edit {{ employee.name }}</h2>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input v-model="employee.id" class="form-control" id="id" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input v-model="employee.name" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input v-model="employee.email" type="email" class="form-control" id="email" placeholder="E-Mail">
                    </div>
                    <!-- TODO: use Date Picker -->
                    <!-- TODO: strip time off date -->
                    <div class="form-group">
                        <label for="date_of_birth">Birthdate</label>
                        <input v-model="employee.date_of_birth" class="form-control" id="date_of_birth" placeholder="Birthdate">
                    </div>
                    <div class="form-group">
                        <label for="address1">Address 1</label>
                        <input v-model="employee.address1" class="form-control" id="address1" placeholder="Address 1">
                    </div>
                    <div class="form-group">
                        <label for="address1">Address 2</label>
                        <input v-model="employee.address2" class="form-control" id="address2" placeholder="Address 2">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input v-model="employee.city" class="form-control" id="city" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input v-model="employee.state" class="form-control" id="state" placeholder="State">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input v-model="employee.postal_code" class="form-control" id="postal_code" placeholder="Postal Code">
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input v-model="employee.country" class="form-control" id="country" placeholder="Country">
                    </div>
                    <div class="form-group">
                        <label for="created_at">Created At</label>
                        <input v-model="employee.created_at" class="form-control" id="created_at" placeholder="Created At" disabled>
                    </div>
                    <div class="form-group">
                        <label for="updated_at">Update At</label>
                        <input v-model="employee.updated_at" class="form-control" id="updated_at" placeholder="Update At" disabled>
                    </div>
                    <div>
                        <button v-on:click="save" class="btn btn-primary">Save</button>

                        <!-- TODO: add delete confirmation -->
                        <button v-on:click="remove" class="btn btn-danger">Delete</button>
                        
                        <router-link to="/" class="btn btn-default">Cancel</router-link>
                    </div>
                    <div v-if="message">{{ message }}</div>
                    <div v-html="error" v-if="error" class="bg-danger errors"></div>
                </div>
            </div>`,
        data: function() {
            return {
                employee: null,
                message: null,
                error: null
            }
        },
        methods: {
            save: function() {
                this.message = null
                this.error = null

                this.$http.put(`/api/employees/${this.employee.id}`, this.employee)
                    .then(response => {
                        this.message = 'Employee updated successfully'
                    })
                    .catch(err => {
                        this.error = Object.keys(err.response.data)
                            .map(key => `${key}: ${err.response.data[key]}`)
                            .join('<br/>')

                    })
            },
            remove: function() {
                this.message = null
                this.$http.delete(`/api/employees/${this.employee.id}`)
                    .then(response => {
                        this.$router.push('/')
                    })
                    .catch(err => {
                        this.message = 'There was a problem deleting the Employee'
                    })
            }
        },
        mounted: function() {
            const id = this.$route.params.id

            this.$http.get(`/api/employees/${id}`)
                .then(response => {
                    this.employee = response.data.employee
                })
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
                        $router.push('/')
                    })
                    .catch(err => {
                        this.error = Object.keys(err.response.data)
                            .map(key => `${key}: ${err.response.data[key]}`)
                            .join('<br/>')
                    })
            }
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
        { path: '/employees/new', component: EmployeeNew, props: { auth: true } },
        { path: '/employees/:id', component: EmployeeEdit, props: { auth: true } },
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
