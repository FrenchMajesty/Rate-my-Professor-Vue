<template>
	<div>
		<Navbar :user="user"></Navbar>
		<div class="md-layout md-gutter no-margin md-alignment-top-space-around space-above">
				<div class="md-layout-item md-medium-size-50 md-size-40">
					<h1 class="md-display-1">Why sign up you ask?</h1>
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
					<md-switch class="switcher" v-model="studentRegistration">Sign up as a {{studentRegistration ? 'student' : 'professor'}}</md-switch>
				</div>
				
				<transition name="registration" mode="out-in">
					<StudentRegistrationCard v-if="studentRegistration"></StudentRegistrationCard>
					<TeacherRegistrationCard v-else></TeacherRegistrationCard>
				</transition>
		</div>
	</div>
</template>

<script>
	import Navbar from '../components/common/Navbar';
	import StudentRegistrationCard from '../components/Auth/StudentRegistrationCard';
	import TeacherRegistrationCard from '../components/Auth/TeacherRegistrationCard';

	export default {
		name: 'Register',
		components: {
			Navbar, StudentRegistrationCard, TeacherRegistrationCard,
		},
		data() {
			return {
				studentRegistration: true,
			};
		},
		computed: {
			user() {
				return this.$store.state.user;
			},
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
	.registration-enter-active, .registration-leave-active {
  transition: opacity .2s ease;
	}
	.registration-enter, .registration-leave-to {
	  opacity: 0;
	}
</style>