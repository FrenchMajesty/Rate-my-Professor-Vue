<template>
	<b-navbar toggleable="md" type="dark" variant="info">
	  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
	  <b-navbar-brand href="#">Company Logo</b-navbar-brand>

	  <b-collapse is-nav id="nav_collapse">
		<b-nav-form class="ml-auto mr-auto col-sm-8 col-md-7 col-lg-5" @submit.prevent="performSearch">
	        <!-- b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search"/-->
	        <Input class="mr-sm-2" type="text" placeholder="Search" style="margin-top: 0" :fullWidth="true" @input="updateQuery" :value="query" />
	        <!--b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button-->
	    </b-nav-form>

	    <b-navbar-nav>
	      <b-nav-item href="#">Home</b-nav-item>
	      <b-nav-item v-show="isAdmin" href="#">Admin Panel</b-nav-item>
	      <b-nav-item v-show="! isLoggedIn" href="#">Sign in</b-nav-item>
	      <b-nav-item-dropdown v-show="isLoggedIn" right>
	        <template slot="button-content">
	          User
	        </template>
	        <b-dropdown-item href="#">Profile</b-dropdown-item>
	        <b-dropdown-item href="#">Signout</b-dropdown-item>
	      </b-nav-item-dropdown>
	    </b-navbar-nav>
	  </b-collapse>
	</b-navbar>
</template>

<script>
	import Input from './form/Input';

	export default {
		name: 'Navbar',
		props: {
			user: {
				type: Object,
				required: true,
			},
			searchData: {
				type: Array,
				required: true,
			}
		},
		components: {
			Input,
		},
		computed: {
			isLoggedIn() {
				return Boolean(this.user);
			},
			isAdmin() {
				return this.user && this.user.rank > 3;
			},
		},
		methods: {
		    updateQuery({target: {value}}) {
		    	this.query = value;
		    },
		    performSearch(e) {
		    	console.log(e);
		    } 
		},
		data() {
			return {
				query: '',
			};
		},
	};
</script>