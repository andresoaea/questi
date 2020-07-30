<template>
	<div class="answers">

		<span v-if="answers.length > 0" class="answers-count">{{ answers.length }} answers:</span>
		<span v-else class="answers-count">No answers yet</span>

		<div v-for="answer in answers" :class="answerWrapperClass(answer.id)" :id="`answer${answer.id}`">
			<div class="user-image"><img src="https://cdn4.iconfinder.com/data/icons/green-shopper/1068/user.png"></div>
		    <div class="user-question">
		    	<header>
		    		<!-- <span class="badge badge-pill badge-success"><i class="fa fa-star-o" aria-hidden="true"></i> &nbsp; {{ authors[questionAuthorIds[question.id]]['role'] | capitalize }}</span> -->
		    	</header>

		    	<h2>{{ answer.text }}</h2>

			    <hr />

			    <footer>

			    	<span v-if="isTheBest(answer.id)" class="float-left best-checked">
			    		<i class="fa fa-check"></i> Best answer
			    	</span>

			    	<span v-tooltip:top="fullnameTooltip(answer)" class="float-left"><i class="fa fa-user-o" aria-hidden="true"></i> &nbsp; {{ getAuthorName(answer, 'firstname') }}</span>

			    <!-- 	<span v-tooltip:top="addedFullTime(question.created_at)" class="float-left"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; {{ question.created_at | relativeTime('Do MMMM') }}</span> -->
			    	
			    	<reactions :answer="answer"></reactions>	

			    </footer>
		    </div>
		</div>
	</div>
</template>


<script>

	import { bus } from '../main'
 	import Reaction  from './subcomponents/Reaction.vue'

	export default {
		
		components: {
			reactions : Reaction
		},
		data() {
			return {
			  answers: [],
			  authors: {},
			  questionId: this.$parent.question.id
			}
		},
		created() {
			// Get the asnwers list from server
			axios.get(siteUrl + '/api/answers/' + this.questionId)
				.then(response => {
					this.answers = response.data.answers
					this.authors = response.data.authors

					if(!(currentUser.id in this.authors)) {
						this.authors[currentUser.id] = currentUser
					}	

					// Scroll to specific answer if defined in url
					setTimeout(() => {
						if(window.location.hash) {
		  					$('html, body').stop().animate({ scrollTop: $(window.location.hash).offset().top })
		  				}
					},400)
				})

			

			//console.log(currentUser.id)

			// if((this.answers.length === 0 && currentUser) || !(currentUser.id in this.authors) )  {
			// 	this.authors[currentUser.id] = currentUser
			// } 

			// Listen for adding new answer
			bus.$on('updateAnswersData', (data) => {
				this.answers.push(data)
			})
		},
		methods: {
			answerWrapperClass: function(id) {
				return 'answer-wrp' + (id === question.best_answer ? ' best' :  '')
			},
			isTheBest: function(id) {
				return id === question.best_answer
			},
		  	getAuthorName: function(answer, which) {
		  		return  this.authors[answer.author][which]
		  	},
		  	fullnameTooltip: function(answer) {
		  		return 'Answered by: ' + this.getAuthorName(answer, 'firstname') 
		  			+ ' ' + (this.getAuthorName(answer, 'lastname') || '')
		  	},
		  	addedFullTime: function(time) {
		  		return 'Added on: ' + this.$options.filters.relativeTime(time, 'LLLL')
		  	}
		  } 

	}
</script>