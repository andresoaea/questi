<template>

	<div>

		<slide-up-down v-if="!currentUser" :active="showLogin" :duration="700">
			<login-form></login-form>
		</slide-up-down>

		<nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" :href="siteUrl">Questi</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" :href="siteUrl">
		          <i class="fa fa-home"></i>
		          Home
		          <span class="sr-only">(current)</span>
		          </a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">
		          <i class="fa fa-envelope-o">
		            <span class="badge badge-danger">11</span>
		          </i>
		          Messages
		        </a>
		      </li>

		    </ul>

		    <form @submit.prevent class="form-inline search-form my-2 my-lg-0">
		      <i :class="['fa', searching ? 'fa-spinner fa-spin' : 'fa-search']"></i>
		      <input @keyup="searchIt" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
		     <!--  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
		    </form>

		    <ul class="navbar-nav float-right">
		    	<li v-if="!currentUser" class="nav-item">
		        <a class="nav-link" href="#" @click.prevent="showLoginForm">
		          <i :class="['fa', showLogin ? 'fa-times ' : 'fa-user']"></i>
		          Login
		        </a>
		      </li>
		      <li v-else class="nav-item dropdown dropdown-user-profile">
		      	
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          <img v-if="currentUser.picture" :src="currentUser.picture | setImageSrc('profile')">
		          <img v-else :src="'user-placeholder.svg' | setImageSrc">

		          {{ currentUser.firstname }}
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" :href="`${siteUrl}/profile`"><i class="fa fa-user"></i> View profile</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" :href="`${siteUrl}/profile/questions`"><i class="fa fa-question-circle-o"></i> My questions</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" :href="`${siteUrl}/logout`" @click.prevent="logout"><i class="fa fa-sign-out"></i> Logout</a>
		        </div>

		        <form id="logout-form" :action="`${siteUrl}/logout`" method="POST" style="display: none;">
                        <input type="hidden" name="_token" :value="csrfToken">
                </form>
				    
		      </li>
		    </ul>
		    
		  </div>
		</nav>

		<header-area></header-area>

	</div>
	
</template>

<script>

	import { bus } from '../main'
	import LoginForm from './LoginForm.vue'
	import HeaderArea from './HeaderArea.vue'
	import SlideUpDown from 'vue-slide-up-down'

	export default {
		components: {
			LoginForm,
			HeaderArea,
			'slide-up-down': SlideUpDown
		},
		data() {
			return {
				csrfToken: '',
				siteUrl: siteUrl,
				showLogin: false,
				currentUser: currentUser,
				searching: false,
				
			}
		},
		methods: {
			showLoginForm: function() {
				this.showLogin = !this.showLogin 
			},
			logout: function() {
				document.getElementById('logout-form').submit()
			},
			searchIt: _.debounce(function(e) {

				this.searching = true

				let queryString = e.target.value;

				// if(queryString) {
					axios.get('get-questions?q=' + queryString)
						.then((response) => {
							// console.log(response.data.questions)
								let _this = this
							 	setTimeout(function() {
							 		bus.$emit('updateQuestions', {
							 			searchQuery: queryString,
							 			questionsData: response.data
							 		})
									_this.searching = false
							 	}, 500)
								
							
						})
				// }
				
			}, 1000)
		},
		created() {

			this.csrfToken = window.$('meta[name="csrf-token"]').attr('content')

			bus.$on('showLogin', (show) => {
				this.showLogin = !this.showLogin 
			})
		}
	}
</script>