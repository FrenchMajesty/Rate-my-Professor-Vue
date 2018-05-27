<template>
	<b-navbar toggleable="md" type="light" variant="white" fixed="top">
	  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
	  <b-navbar-brand href="#">Company Logo</b-navbar-brand>

	  <b-collapse is-nav id="nav_collapse">

	  		<!-- Search input -->
	  		<transition
	  			name="search"
	  			mode="out-in"
	  			enter-active-class="animated bounceIn"
	  			leave-active-class="animated bounceOut"
	  		>
				<NavbarSearchForm 
					v-if="! dataIsLoading && canShowSearchBar"
					:profData="this.$store.state.prof.data"
				></NavbarSearchForm>
				<div v-else class="mr-auto ml-auto text-center">
	    			<md-progress-spinner 
	    				:md-diameter="50"
	    				:md-stroke="5"
	    				md-mode="indeterminate"
	    			></md-progress-spinner>
				</div>
			</transition>
	    <b-navbar-nav>
	    	<md-button :to="{name: 'professor', params:{slug: 'fredrick-weimann'}}" class="no-margin">Home</md-button>
	    	<md-button v-if="isAdmin" href="#" class="no-margin">Admin Panel</md-button>
	    	<md-button v-if="! isLoggedIn" :to="{name: 'signin'}" class="no-margin">Sign In</md-button>
	    	<div v-else>
			    <div v-if="smallScreenSize">
				    <md-divider></md-divider>
		    		<md-button href="#" class="no-margin full-width">Profile</md-button>
		    		<md-button href="#" class="no-margin full-width">Sign out</md-button>
			    </div>
		    	<md-menu v-else md-size="auto" md-align-trigger>
			      <md-button href="#" class="full-width" md-menu-trigger>{{user.name}}</md-button>
			      <md-menu-content class="above-all">
			        <md-menu-item :to="{name: 'home'}">Profile</md-menu-item>
			        <md-menu-item :to="{name: 'changePassword'}">Change Password</md-menu-item>
			        <md-menu-item href="#" @click="logout">Sign out</md-menu-item>
			      </md-menu-content>
			    </md-menu>
			</div>
	    </b-navbar-nav>
	  </b-collapse>
	</b-navbar>
</template>

<script>
	import { loadAllProfessorsData, loadAllSchoolsData, submitLogout } from 'Js/store/api';
	import NavbarSearchForm from './NavbarSearchForm';
	import Fetcher from 'Js/lib/Fetcher';

	export default {
		name: 'Navbar',
		components: {
			NavbarSearchForm,
		},
		/**
		 * Wait 1 sec before allowing the search bar to show to avoid useless transitions
		 */
		mounted() {
			setTimeout(() => this.canShowSearchBar = true, 700);
		},
		/**
		 * Verify if the search data is being loaded and if not, call fetchData() method
		 */
		created() {
			const {data, beingFetched} = this.$store.state.prof;
			if(!data && !beingFetched) {
				this.fetchData();
			}
		},
		data() {
			return {
				/**
				 * Render condition of the search bar
				 * @type {Boolean}
				 */
				canShowSearchBar: false,
			};
		},
		computed: {
			/**
			 * Get the user object model from the state
			 * @return {Object} 
			 */
			user() {
				return this.$store.state.user;
			},

			/**
			 * Determine if the user is logged in
			 * @return {Boolean} 
			 */
			isLoggedIn() {
				return Boolean(this.user);
			},

			/**
			 * Determine if the user is an administrator
			 * @return {Boolean} 
			 */
			isAdmin() {
				return this.user && this.user.rank > 3;
			},

			/**
			 * Determine whether the screen is small (< 775px)
			 * @return {Boolean} 
			 */
			smallScreenSize(){
				return window.innerWidth < 775;
			},

			/**
			 * Current state of the search data fetching request
			 * @return {Boolean} 
			 */
			dataIsLoading() {
				return this.$store.state.prof.beingFetched || this.$store.state.school.beingFetched;
			},
		},
		methods: {
			/**
			 * Fetch all the professors's and schools data from the API and commit the actions
			 */
			fetchData() {
				Fetcher.schools(this);
				Fetcher.profs(this);
			},

			/**
			 * Process a request to log out a user
			 * @return {Void} 
			 */
			logout() {
				submitLogout()
				.then(() => {
					this.$store.commit({
						type: 'updateUser',
						user: null,
					});

					this.$store.commit({
						type: 'updateAccessToken',
						token: null,
						expire: null,
					});

					this.$router.push({name: 'index'});
				})
				.catch(err => console.log(err));
			},
		},
	};
</script>

<style scoped>
	.no-margin {
		margin: 0;
	}
	.full-width {
		width: 100%;
	}
	.above-all {
		z-index: 9999;
	}
</style>