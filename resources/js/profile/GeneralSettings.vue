<template>

	<div>

		<header class="section-title">
			<p>General Settings</p>
			<hr />
		</header>
		
		<form @submit.prevent="save"  @keydown="form.onKeydown($event)">
			<table>
				<tr>
					<td>Firstname</td>
					<td><input v-model="form.firstname" type="text" name="firstname"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('firstname') }" placeholder="Type your firstname here.." v-on:input="updateData('firstname')">
					        <has-error :form="form" field="firstname"></has-error>
					    </td>
					         

				</tr>
				<tr>
					<td>Lastname</td>
					<td><input v-model="form.lastname" type="text" name="lastname"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('lastname') }" placeholder="Type your lastname here.." v-on:input="updateData('lastname')">
					        <has-error :form="form" field="lastname"></has-error>
					    </td>
					        
				</tr>			
				<tr>
					<td>Profile picture</td>
					<td>
						<div class="upload-btn-wrapper">
						  <div class="btn">{{ uploadText('picture') }}</div>
						  <input type="file" :class="{ 'is-invalid': form.errors.has('firstname') }" name="picture" accept="image/*" @change="onFileChange" />
						</div>
						<button v-if="canDeletePicture" @click.prevent="deletePicture" type="button" class="btn btn-delete btn-outline-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						<has-error :form="form" field="picture"></has-error>
					</td>
				</tr>
				<tr>
					<td>Username</td>
					<td><input v-model="form.username" type="text" name="username"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('username') }" placeholder="Type your username here.." v-on:input="updateData('username')">
					        <has-error :form="form" field="username"></has-error>
					    </td>
					        
				</tr>
				<tr>
					<td>Email</td>
					<td><input v-model="form.email" type="email" name="email"
					        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Type your email here.." v-on:input="updateData('email')">
					        <has-error :form="form" field="email"></has-error>
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
		name: 'general-settings',
		computed: {
			user() {
				//return this.$store.state.user
				let user = this.$store.state.user

				for( let formElement in this.form ) {
		    		if(user[formElement]) {

		    			if(formElement === "picture") {
		    				continue
		    			}

		    			this.form[formElement] = user[formElement]
		    		}
		    	}

		    	return user
			},
			canDeletePicture() {
				return this.$store.state.user.picture
			}
		},
		//props: ['data'],
		data() {
			return {
				form: new Form({
					firstname: '',
					lastname: '',
					username: '',
					email: '',
					picture: null
				})
			}
		},
		// watch: {
		// 	user: {
		// 	    deep: true,
		// 	    handler(data) {
		// 	    	for( let formElement in this.form ) {
		// 	    		if(data.user[formElement]) {

		// 	    			if(formElement === "picture") {
		// 	    				continue
		// 	    			}

		// 	    			this.form[formElement] = data.user[formElement]
		// 	    		}
		// 	    	}
		// 	    }
		// 	}
		// },
		methods: {
			updateData(whatData, value = null) {
				// this.$emit('update-data', {
				// 	toChange : whatData,
				// 	value: value || this.form[whatData]
				// })

				this.$store.state.user[whatData] = value || this.form[whatData]
			},
			onFileChange(e) {
				this.form.errors.errors.picture = null
		        let file = e.target.files[0]
		        let limit = 1024 * 1024 * 2;

		        if(!file.type.includes('image/')) {
			      	this.form.errors.set({
			      		picture : 'Please select an image. Accepted files: .jpeg .jpg .png'
			      	})
			      	return
		     	}

		     	if(file.size > limit) {
		     		this.form.errors.set({
			      		picture : 'Maximum file size allowed is 2MB'
			      	})
			      	return
		     	}



		     //	this.form.picture = file


		     	//Prepare base64 for backend 
		     	let reader = new FileReader();
		     	reader.onloadend = (file) => {
                    this.form.picture = reader.result;
                }
                reader.readAsDataURL(file);

		     	// Update image on frontend 
		        let fileUrl = URL.createObjectURL(file)
		        this.updateData('picture', fileUrl)
		    },
		    deletePicture() {

		    	swal({
				  title: 'Are you sure?',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, delete it!'
				}).then((result) => {

				  if (result.value) {

				  	this.$Progress.start()

			    	axios.delete(siteUrl + '/api/profile/image')
			    		.then((response) => {
			    			this.$Progress.finish()

			    			swal(
						      'Deleted!',
						      'Your image has been deleted.',
						      'success'
						    )

			    			this.$store.state.user.picture = null
			    			this.form.picture = null

			    // 			toast({
							//   type: 'success',
							//   title: 'Your profile picture has been deleted'
							// })
			    		})
			    		.catch((error) => {
			    			
			    			this.$Progress.fail()

			    			toast({
							  type: 'error',
							  title: 'Ooops.. Something went wrong. Please try again later.'
							})
			    		}) 
				    
				  }
				})


		    },
		    uploadText(inputField) {
		    	return this.user[inputField] ? 'Change image' : 'Upload an image'
		    },
		    save() {

		    	this.$Progress.start()

		    	this.form.post(siteUrl + '/api/profile/general')
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