<template>
	
	<div v-if="!currentUser && isHome" class="parallax-container">
      <div class="overlay">
      		<div class="container">
      			<div class="row">
	      			<div class="col-sm-8">
	      				<h3>Share and grow the world's knowledge!</h3>
	      				<p>We want to connect the people who have knowledge to the people who need it, to bring together people with different perspectives so they can understand each other better, and to empower everyone to share their knowledge.</p>
	      			</div>
	      			<div class="col-sm-4 col-create-new-account">
	      				<a :href="`${siteUrl}/register`">Create a new account</a>
	      			</div>
      			</div>
      		</div>
      </div>
      <parallax class="header-parallax" :speed-factor="0.4">
        <img src="https://images.unsplash.com/photo-1539406176308-c5bbad125d10?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=ba8dfa85c97a37df0b8f33afc764173d&auto=format&fit=crop&w=667&q=80">
      </parallax>
    </div>
	
</template>

<script>
	
	import Parallax from "vue-parallaxy"

	export default {
		name: 'header-area',
		components: {
			Parallax
		},
		data() {
			return {
				currentUser: currentUser,
				siteUrl: siteUrl,
				isHome: isHome
			}
		}
	}

</script>