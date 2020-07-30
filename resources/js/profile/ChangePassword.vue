<template>

	<div>
		
		<header class="section-title">
			<p>Password</p>
			<hr />
		</header>

		<form @submit.prevent="save"  @keydown="form.onKeydown($event)">
			<table>
				<tr>
					<td>Current password</td>
					<td><input v-model="form.current_password" type="password" name="current_password"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('current_password') }" placeholder="Type your current password here.." />
					        <has-error :form="form" field="current_password"></has-error>
					    </td>
					         

				</tr>
				<tr>
					<td>New Password</td>
					<td><input v-model="form.password" type="password" name="password"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Type your new password here.." />
					        <has-error :form="form" field="password"></has-error>
					    </td>
					        
				</tr>
				<tr>
					<td>Confirm new password</td>
					<td><input v-model="form.password_confirmation" type="password" name="password_confirmation"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" placeholder="Typte again your new here.." />
					        <has-error :form="form" field="password_confirmation"></has-error>
					    </td>
				</tr>
			</table>

			<hr />

			<button :disabled="form.busy" type="submit" class="btn btn-outline-success">Save changes</button>

		</form>

	</div>
		
</template>

<script>
	
	export default {
		data() {
			return {
				form: new Form({
					current_password: '',
					password: '',
					password_confirmation: ''
				})
			}
		},
		methods: {
			save() {

		    	this.$Progress.start()

		    	this.form.post(siteUrl + '/api/profile/change-password')
		    		.then(response => {

		    			this.$Progress.finish()

		    			toast({
						  type: 'success',
						  title: 'Your changes has been saved'
						})

		    		})
		    		.catch((error) => {
		    			this.$Progress.fail()

		    			if(error.response.status === 422) {
		    				return
		    			}

		    			toast({
						  type: 'error',
						  title: 'Ooops.. Something went wrong. Please try again later.'
						})
		    		})
		    }
		}
	}

</script>