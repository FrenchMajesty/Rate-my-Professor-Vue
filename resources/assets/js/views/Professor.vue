<template>
	<ProfileContainer :user="shared.user" :searchData="searchData">
		<ProfessorDetailsCard 
			:prof="prof" 
			:numberOfSimilarProfs="numberOfSimilarProfs"
		></ProfessorDetailsCard>
		
		<div class="md-layout-item md-size-100 md-layout">
			<p v-if="hasRatings" class="md-layout-item md-title md-size-100">Student Reviews</p>
			<ProfessorReview
				v-if="hasRatings"
				v-for="rating in prof.ratings"
				:key="rating.id"
				:rating="rating"
			></ProfessorReview>

			<div v-if="!hasRatings" class="md-layout md-alignment-center-center">
				<md-empty-state
					class="md-layout-item"
			      	md-icon="info_outline"
			      	md-label="No reviews for the moment"
			      	md-description="There seems to be no review available for this professor.. Why not be the first to write one?">
			     	<md-button class="md-primary md-raised">Write a review</md-button>
			    </md-empty-state>
			</div>
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
					ratings: [
						{
							id: 1,
							overall_rating: 2.4,
							difficulty_rating: 3.0,
							comment: 'I dont even like eating ice cream!!',
							class: 'MATH0022',
							grade_received: 'B+',
							textbook_used: true,
							would_retake: true,
						},
						{
							id: 2,
							overall_rating: 4.9,
							difficulty_rating: 3.0,
							comment: 'Pretty chill guy.',
							class: 'MATH4502',
							grade_received: 'C-',
							textbook_used: true,
							would_retake: false,
						},
					],
				},
				shared: {
					user,
				}
			};
		},
		computed: {
			hasRatings() {
				return this.prof.ratings.length > 0;
			},
			numberOfSimilarProfs() {
				return {
					school: 2,
					department: 7,
				};
			},
		},
	};
</script>

<style scoped>
	.md-title {
		margin: 2em 0;
	}
</style>