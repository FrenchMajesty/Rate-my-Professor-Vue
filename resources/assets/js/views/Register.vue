<template>
	<div>
		<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
				<div class="md-layout-item md-small-size-100 md-medium-size-50 md-size-40">
					<h1 class="md-display-1 md-small-hide">Why sign up you ask?</h1>
					<div class="md-small-hide">
						<md-list v-if="studentRegistration" class="perk-list">
							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">Find your professors faster</span>
							</md-list-item>

							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">Set your own preferences</span>
							</md-list-item>

							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">Access to your recent searches</span>
							</md-list-item>

							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">You still remain anonymous as usual</span>
							</md-list-item>
						</md-list>
						<md-list v-else class="perk-list">
							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">Add a photo or a twitter handle</span>
							</md-list-item>

							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">Receive alerts when a rating is added to your page</span>
							</md-list-item>

							<md-list-item>
								<md-icon class="text-success">check_circle</md-icon>
								<span class="md-list-item-text">Let your students know you care about their feedback</span>
							</md-list-item>
						</md-list>
					</div>
					<div class="text-center mr-auto ml-auto">
						<md-switch class="switcher" v-model="studentRegistration">Sign up as a {{studentRegistration ? 'student' : 'professor'}}</md-switch>
					</div>
				</div>
				
				<transition
					name="flip"
					mode="out-in"
				>
					<StudentRegistrationCard :class="registrationCardClass" v-if="studentRegistration"></StudentRegistrationCard>
					<TeacherRegistrationCard :class="registrationCardClass" v-else></TeacherRegistrationCard>
				</transition>
		</div>
	</div>
</template>

<script>
	import StudentRegistrationCard from '../components/Auth/StudentRegistrationCard';
	import TeacherRegistrationCard from '../components/Auth/TeacherRegistrationCard';

	export default {
		name: 'Register',
		components: {
			StudentRegistrationCard, TeacherRegistrationCard,
		},
		data() {
			return {
				/**
				 * Condition to show the student or professor registration car
				 * @type {Boolean}
				 */
				studentRegistration: true,

				/**
				 * The class to set to the registrations cards
				 * @type {String}
				 */
				registrationCardClass: 'md-layout-item md-small-size-75 md-size-40 md-layout md-gutter md-alignment-top-space-around',
			};
		},
	};
</script>

<style scoped>
	.space-below {
		margin-bottom: 10px;
	}
	.perk-list {
		font-size: 1.5em;
		background-color: #0000;
	}
	.switcher {
		font-size: 2em;
		margin-top: 2em;
	}
	.flip-enter-active {
	  transition: all .2s cubic-bezier(0.55, 0.085, 0.68, 0.53);
	}

	.flip-leave-active {
	  transition: all .25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
	}

	.flip-enter, .flip-leave-to {
	  transform: scaleX(0) translateZ(0);
	  opacity: 0;
	}
</style>