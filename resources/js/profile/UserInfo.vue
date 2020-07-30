<template>

	<div>

		<div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" :style="`background: url('${ coverImage }') center center`">
                <h3 class="widget-user-username">{{ fullname }}</h3>
                <h5 class="widget-user-desc">{{ user.role  }}</h5>
              </div>
              <div class="widget-user-image">
              	<img v-if="userImage" :src="userImage"  class="img-circle" alt="User Avatar" />
                <img v-else class="img-circle" :src="'user-placeholder.svg' | setImageSrc" alt="User Avatar" />

              </div>
              <div class="card-footer">

              	<div class="text-center user-sumar">
              		<p>Username: <span>{{ user.username }}</span></p>
              		<p>Registered on: <span>{{ user.created_at | relativeTime('Do MMMM YYYY') }}</span></p>
              		<p>Last login: <span>{{ user.last_login | relativeTime('MMMM Do YYYY, h:mm a') }}</span></p>
              	</div>

              	<ul class="nav flex-column">
                  <li class="nav-item">
                    <router-link to="/profile" class="nav-link">
                      <i class="fa fa-cogs" aria-hidden="true"></i> General Settings 
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/profile/change-password" class="nav-link">
                      <i class="fa fa-key" aria-hidden="true"></i> Change Password 
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/profile/questions"class="nav-link">
                      <i class="fa fa-question" aria-hidden="true"></i> Questions
                      <span class="float-right badge bg-success">{{ getProperty('questionsCount') }}</span>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/profile/answers" class="nav-link">
                      <i class="fa fa-reply-all" aria-hidden="true"></i> Answers 
                      <span class="float-right badge bg-danger">{{ getProperty('answersCount') }}</span>
                    </router-link>
                  </li>
                </ul>

              </div>
            </div>
	</div>
</template>

<script>
		
	export default {
		name: 'user-info',
		props: ['data'],
		computed: {
			user() {
				return this.data.user
			},
			fullname() {
				return this.user.firstname + ' ' + (this.user.lastname || '')
			},
			userImage() {

				if(!this.user.picture) {
					return false
				}

				return this.user.picture.includes('store-') ?
					siteUrl + '/image-storage/profile/small-' +  this.user.picture : this.user.picture

			},
			coverImage() {
				return this.$options.filters.setImageSrc('cover-placeholder.jpg')
			}
		
		},
		methods: {
			getProperty(property) {
				return this.$store.state[property]
			}
		}

	}	

</script>