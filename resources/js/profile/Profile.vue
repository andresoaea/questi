<template>
	<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="user-info"><user-info :data="data"></user-info></div>
				</div>
				<div class="col-sm-6 col-lg-8">
					<!-- <div><general-settings :data="data" @update-data="updateData"></general-settings></div> -->
					<div><router-view></router-view></div>
				</div>
			</div>
		</div>	

	
</template>

<script>
	
	import UserInfo from './UserInfo.vue'
	//import GeneralSettings  from './GeneralSettings.vue'

	export default {
		components: {
			UserInfo
		},
		data() {
			return {
				data: {
					user: {}
				}
			}
		},	
		created: function() {
			axios.get( siteUrl + '/api/profile')
				 .then((response) => {
				 	this.data.user = response.data.user

				 	for(let property in this.$store.state) {
				 		this.$store.state[property] = response.data[property]
				 	}

				 })
		

		}
		// methods: {
		// 	updateData(newData) {
		// 		//console.log(data)
		// 		this.data.user[newData.toChange] = newData.value
		// 	}
		// }


	}	

</script>