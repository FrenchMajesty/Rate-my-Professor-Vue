<template>
	<div>
		<Navbar :user="user" :searchData="searchData"></Navbar>
		<div class="row space-above">
			<div class="col-md-4">
				<QuickSearch :searchData="searchData" />
			</div>
			<div class="col-md-8">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
	import Navbar from './common/Navbar';
	import QuickSearch from './QuickSearch';

	export default {
		name: 'ProfileContainer',
		components: {
			Navbar, QuickSearch
		},
		props: {
			user: {
				type: Object,
			},
			searchData: {
				type: Array,
				required: true,
			}
		},
	};
</script>

<style scoped>
	.space-above {
		padding-top: 5em;
	}
</style>