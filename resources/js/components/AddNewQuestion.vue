<template>
	<div>
		<form @submit.prevent="add" @keydown="form.onKeydown($event)">
	    <div class="form-group">
	      <label>Question Title</label>
	      <input v-model="form.title" type="text" name="title"
	        class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
	      <has-error :form="form" field="title"></has-error>
	    </div>

	    <div class="form-group">
	      <label>Question Description</label>
	      <input v-model="form.description" type="text" name="description"
	        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
	      <has-error :form="form" field="description"></has-error>
	    </div>

	    <div class="form-group">
	      <label>Question Category</label>
	      <select v-model="form.category" type="text" name="category"
	        class="form-control" :class="{ 'is-invalid': form.errors.has('category') }">
	        <option value="" disabled selected>Select your option</option>
	        <option v-for="(category, key, index) in categories" :value="key">{{ category }}</option>
	      </select>
	      <has-error :form="form" field="category"></has-error>
	    </div>

	    <button :disabled="form.busy" type="submit" class="btn btn-primary">Add Question</button>
	  </form>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: new Form({
					title: '',
					category: '',
					description: ''
				}),
				categories: categories
			}
		},
		methods: {
		    add() {

		      // Snow progress bar
		      this.$Progress.start();

		      // Submit the form via a POST request
		      this.form.post('save-question')
		        .then(({ data }) => { 
		        	// Hide progress bar
		        	this.$Progress.finish();

		        	// Show confirmation
		        	swal({
					  position: 'center',
					  type: 'success',
					  html: '<h4>Your question has been added</h4>',
					  showConfirmButton: false,
					  showCancelButton: true
					});
		        })
		        .catch((error) => { 
		        	this.$Progress.fail();
		        	
		        	if(error.response.status !== 422) {
		        		swal({
						  position: 'center',
						  type: 'error',
						  html: `
						  	<h4>Oops. Something went wrong..</h4>
						  	<p>Your question wasn't saved in our database.</p>
						  	<h5>Please try again later!</h5>
						  `,
						  showConfirmButton: false,
						  showCancelButton: true
						});
		        	}

		        })


		    }
		}
	}
</script>