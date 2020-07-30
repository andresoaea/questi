<template>
	<div>
		<header class="section-title">
			<p class="float-left">{{ user.firstname }} user answers</p>
			<span class="float-right"> Total: {{ getProperty('answersCount') }}</span>
			<div class="clearfix"></div>
			<hr class="cleared" />
		</header>

		<!-- <ul><li v-for="answer in answersData.data">{{ answer.text }}</li></ul> -->

		<table class="table user-data-table answers-list-table">
			<tr v-for="answer in answersData.data">
				<td class="users-image">
					<img v-tooltip:top="getFullName(user)" :src="user.picture | setImageSrc('profile')" class="img-circle">
					<i class="fa fa-forward" aria-hidden="true"></i>
					<img v-tooltip:top="getFullName(answer.related_author)" :src="answer.related_author.picture | setImageSrc('profile')" class="img-circle">
				</td>
				<td>
					<a :href="answerLink(answer)" target="_blank">{{ answer.text }}</a>
					<hr />
					<p>Response for question:</p>
					<p>{{ answer.related_question.title }}</p>
				</td>
			</tr>
		</table>


		<pagination class="float-right" :limit="2" :data="answersData" @pagination-change-page="getResults"></pagination>

		<div class="clearfix"></div>

	</div>
</template>

<script>
	
	export default {
		data() {
			return {
				answersData: {}
			}
		},
		computed: {
			user() {
				return this.getProperty('user')
			}
		},
		mounted() {
			this.getResults()
		},
		methods: {
			getProperty(property) {
				return this.$store.state[property]
			},
			getResults(page = 1) {
				axios.get(siteUrl + '/api/profile/data/answers?page=' + page)
					.then(response => {
						this.answersData = response.data;
					});
			},
			getFullName(user) {
				return user.firstname + ' ' + (user.lastname || '')
			},
			answerLink(answer) {
				let question = answer.related_question
				return siteUrl + '/' + question.category_slug + '/' + question.slug + '#answer' + answer.id
			}
		}

	}

</script>