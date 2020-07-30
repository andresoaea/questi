<template>
	<span class="likes-dislikes">
		<span @click="getLiked" class="mr0" v-ReactionTooltip:bottom="{show: isLiked, for: 'like'}"><i :class="`like fa ${[isLiked ? 'fa-thumbs-up active': 'fa-thumbs-o-up']}`" aria-hidden="true"></i> {{ likes }}</span> &nbsp;
		<span @click="getDisliked" class="mr0" v-ReactionTooltip:bottom="{show: isDisliked, for: 'dislike'}"><i :class="`dislike fa ${[isDisliked ? 'fa-thumbs-down active': 'fa-thumbs-o-down']}`" aria-hidden="true"></i> {{ dislikes }}</span>
	</span>
</template>

<script>
	
	import { bus } from '../../main'

	export default {
		name: 'reactions',
		props: ['reactions-data', 'answer'],
		data() {
			return {
				id: null,
				likes : 0,
				dislikes: 0,
				isLiked: false,
				isDisliked: false
			}
		},
		watch: {
			reactionsData : function() {

				if(this.answer) {
					return
				}

				let data = this.reactionsData;
				this.likes = data.reactions.likes
				this.dislikes = data.reactions.dislikes

				if(data.isLiked) {
					this.isLiked = true
				}

				if(data.isDisliked) {
					this.isDisliked = true
				}

			}
		},
		directives: {
			ReactionTooltip : function(el, binding) {
				if(binding.value.show) {
			    	$(el).tooltip({
			             title: binding.value.for === 'like' ? 'You like this' : 'You dislike this',
			             placement: binding.arg,
			             trigger: 'hover',
			                        
			         })
			    }

			    if(!currentUser) {

			    	let msg = binding.value.for === 'like' ? 'Do you like this?' : 'Don\'t you like this?'
				    	
			    	$(el).popover({
			    		html: true,
			    		content: `
			    			<div class="text-center">
			    				<p class="font-weight-bold"> ${msg} </p>
			    				<p>Sign in to make your point known</p>
			    				<a href="../login">
				    				<button class="btn btn-info">Connect</button>
				    			</a>
			    			</div>
			    		`,
			    		placement: 'bottom',
			    	})
			    }
			}
		},
		created() {
			if(this.answer) {

				this.id = this.answer.id

				if(this.answer.reactions) {
					let likes = JSON.parse(this.answer.reactions).like
					if(likes) {
						this.likes = Object.keys(likes).length

						if(currentUser && likes.indexOf(currentUser.id) != -1) {
							this.isLiked = true
						}
					}
					
					let dislikes = JSON.parse(this.answer.reactions).dislike
					if(dislikes) {
						this.dislikes = Object.keys(dislikes).length

						if(currentUser && dislikes.indexOf(currentUser.id) != -1) {
							this.isDisliked = true
						}
					}

				}
				
			} else {
				this.id = this.$parent.question.id
			}

		},
		methods: {
			destroyTooltip: function(target) {
				$(target).parent().find('span').not(target).tooltip('dispose')
			},
			getLiked: function(e) {
				if(!currentUser) {
					return
				}
				
				if(this.isDisliked === true) {
					this.removeReaction('dislike', true)
					this.destroyTooltip(e.currentTarget)

					return
				}
				if(this.isLiked === true) {
					this.removeReaction('like')
					return
				}

				this.addReaction('like')	
				
			},
			getDisliked: function(e) {
				if(!currentUser) {
					return
				}

				if(this.isLiked === true) {
					this.removeReaction('like', true)
					this.destroyTooltip(e.currentTarget)
					return
				}
				if(this.isDisliked === true) {	
					this.removeReaction('dislike')			
					return
				}

				this.addReaction('dislike')
				
			},
			addReaction : function(reaction) {
				axios.post(siteUrl + '/api/reaction', 
					{for: this.id, reaction: reaction, type: this.checkType()})
					.then(() => {
						if(reaction === 'like') {
							this.likes++
							this.isLiked = true
						} else {
							this.dislikes++
				 			this.isDisliked = true
						}
					})
			},
			removeReaction: function(reaction, replace = null) {
				axios.post(siteUrl + '/api/reaction/delete', 
					{for: this.id, reaction: reaction, type: this.checkType()})
					.then(() => {
						if(reaction === 'like') {
							this.likes--
							this.isLiked = false
						} else {
							this.dislikes--
							this.isDisliked = false
						}

						$('[role=tooltip]').tooltip('dispose')

						if(replace) {
							this.addReaction((reaction === 'like' ? 'dislike' : 'like'))
						}
					})
			},	
			checkType: function() {
				return this.answer ? 'answer' : 'question'
			},
			showLogin: function() {
		    	bus.$emit('showLogin', true)
		    }
		}
	}

</script>