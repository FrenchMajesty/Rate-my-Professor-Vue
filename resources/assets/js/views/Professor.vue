<template>
	<ProfileContainer :user="shared.user" :searchData="searchData">
		The profile goes here mate
	</ProfileContainer>
</template>

<script>
	import ProfileContainer from '../components/ProfileContainer';
	import {user} from '../shared';

	export default {
		name: 'Professor',
		components: {
			ProfileContainer,
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