<template>
	<div>
		<Navbar :user="shared.user" :searchData="searchData"></Navbar>
		<div class="row space-above">
			<div class="col-md-4">
				<QuickSearch :searchData="searchData" />
			</div>
			<div class="col-md-8">
				Synopsis here son..
			</div>
		</div>
	</div>
</template>

<script>
	import Navbar from '../components/common/Navbar';
	import QuickSearch from '../components/QuickSearch';
	import {user} from '../shared';

	export default {
		name: 'Professor',
		components: {
			Navbar, QuickSearch
		},
		data() {
			return {
				searchData: [],
				shared: {
					user,
				}
			}
		},
	};
</script>

<style scoped>
	.space-above {
		padding-top: 5em;
	}
</style>