<template>
	<ProfileContainer :user="shared.user" :searchData="searchData">
		<ProfessorDetailsCard :prof="prof" :similarProfs="[]"></ProfessorDetailsCard>
		
		<p v-if="prof.ratings.length > 0" class="md-title">Student Reviews</p>
		<div class="md-layout md-gutter" v-if="prof.ratings.length > 0">
			<ProfessorReview
				size="md-size-80"
				v-for="rating in prof.ratings"
				:key="rating.id"
				:rating="rating"
			></ProfessorReview>
		</div>
		<div v-else>
			<md-empty-state
	      md-icon="info_outline"
	      md-label="No reviews for the moment"
	      md-description="There seems to be no review available for this professor.. Why not be the first to write one?">
	      <md-button class="md-primary md-raised">Write a review</md-button>
	    </md-empty-state>
		</div>
	</ProfileContainer>
</template>

<script>
	import ProfileContainer from '../components/ProfileContainer';
	import ProfessorDetailsCard from '../components/ProfessorDetailsCard';
	import ProfessorReview from '../components/ProfessorReview';
	import {user} from '../shared';

	export default {
		name: 'Professor',
		components: {
			ProfileContainer, ProfessorDetailsCard, ProfessorReview,
		},
		data() {
			return {
				searchData: [],
				prof: {
					name: 'John Doe',
					department: {
						id: 9,
						name: 'Science',
					},
					school: {
						id: 99,
						name: 'Harvard',
						location: 'College Station,TX',
					},
					avgRatings: {
						overall: 2.3,
						difficulty: 4.5,
					},
					ratings: [
						{
							id: 1,
							overall_rating: 2.4,
							difficulty_rating: 3.0,
							comment: 'I dont even like eating ice cream!!',
						},
					],
				},
				shared: {
					user,
				}
			};
		},
	};
</script>

<style scoped>
	.md-title {
		margin: 2em 0;
	}
</style>