<template>
	<div class="member-area">
		<div class="container">
			<div class="row">	

				<div class="col-sm-6 col-login">
					
					<h5>Member Login</h5>

					<form @submit.prevent="login" @keydown="form.onKeydown($event)">
					    <div class="form-group">
					      <input v-model="form.identity" type="text" name="identity"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('identity') }" placeholder="Username or Email">
					        <i class="fa fa-user"></i>
					      <has-error :form="form" field="identity"></has-error>
					    </div>

					    <div class="form-group">
					      <input v-model="form.password" type="password" name="password"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
					        <i class="fa fa-lock"></i>
					      <has-error :form="form" field="password"></has-error>
					    </div>

					    <button :disabled="form.busy" class="member-action" type="submit">Login</button>
			    	</form>
					
				</div>	

				<div class="col-sm-6 col-register">
					<h5>Register</h5>
					<p>Create an account to our website and get help from other people. Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries..</p>
					<a :href="registerLink" class="member-action btn-register">Create new account</a>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	
	export default {
		name: 'login-form',
		data() {
			return {
				form: new Form({
					identity: '',
					password: '',
					remember: ''
				})
			}
		},
		methods: {
			login: function() {
				 this.form.post(siteUrl + '/login')
					.then((response) => {

						if(response.data.auth) {
							window.location.reload()
						}

					})
					.catch((error) => {
						console.log(error)
					})

			}
		},
		computed: {
			registerLink() {
				return siteUrl + '/register'
			}
		}
	}

</script>