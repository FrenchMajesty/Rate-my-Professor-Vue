<template>
	<b-navbar toggleable="md" type="light" variant="white" fixed="top">
	  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
	  <b-navbar-brand href="#">Company Logo</b-navbar-brand>

	  <b-collapse is-nav id="nav_collapse">

	  		<!-- Search input -->
			<NavbarSearchForm></NavbarSearchForm>

	    <b-navbar-nav>
	    	<md-button href="#" class="no-margin">Home</md-button>
	    	<md-button v-if="isAdmin" href="#" class="no-margin">Admin Panel</md-button>
	    	<md-button v-if="! isLoggedIn" href="#" class="no-margin">Sign In</md-button>
	    	<div v-else>
			    <div v-if="smallScreenSize">
				    <md-divider></md-divider>
		    		<md-button href="#" class="no-margin full-width">Profile</md-button>
		    		<md-button href="#" class="no-margin full-width">Sign out</md-button>
			    </div>
		    	<md-menu v-else md-size="auto" md-align-trigger>
			      <md-button href="#" class="full-width" md-menu-trigger>User's name</md-button>
			      <md-menu-content class="above-all">
			        <md-menu-item to="#poo">Profile</md-menu-item>
			        <md-menu-item to="#out">Sign out</md-menu-item>
			      </md-menu-content>
			    </md-menu>
			</div>
	    </b-navbar-nav>
	  </b-collapse>
	</b-navbar>
</template>

<script>
	import NavbarSearchForm from './NavbarSearchForm';

	export default {
		name: 'Navbar',
		components: {
			NavbarSearchForm,
		},
		props: {
			user: {
				type: Object,
			},
		},
		computed: {
			isLoggedIn() {
				return Boolean(this.user);
			},
			isAdmin() {
				return this.user && this.user.rank > 3;
			},
			smallScreenSize(){
				return window.innerWidth < 775;
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