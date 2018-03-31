<template>
	<ProfileContainer v-if="professor">
		<ProfessorDetailsCard 
			class="animated slideInDown"
			:prof="professor" 
			:school="professorSchool"
			:ratings="ratingsAreReady ? ratings : null"
			:numberOfSimilarProfs="numberOfSimilarProfs"
		></ProfessorDetailsCard>
		<div 
			v-if="ratingsAreReady"
			class="md-layout-item md-size-100 md-layout"
		>
			<p v-if="hasRatings" class="md-layout-item md-title md-size-100">Student Reviews</p>
			<ProfessorReview
				class="animated fadeInUp"
				v-if="hasRatings"
				v-for="(rating, i) in ratings"
				:key="rating.id"
				:rating="rating"
				:delay="(i+1) * 200"
			></ProfessorReview>

			<div v-if="! hasRatings" class="md-layout md-alignment-center-center">
				<md-empty-state
					class="md-layout-item"
			      	md-icon="info_outline"
			      	md-label="No reviews for the moment"
			      	md-description="There seems to be no review available for this professor.. Why not be the first to write one?">
			     	<md-button class="md-primary md-raised">Write a review</md-button>
			    </md-empty-state>
			</div>
		</div>
		<div
			class="md-layout md-alignment-center-center"
			style="margin-top: 3em" 
			v-else
		>
			<md-progress-spinner 
				:md-diameter="60"
				:md-stroke="6"
				md-mode="indeterminate"
			></md-progress-spinner>
		</div>
	</ProfileContainer>
</template>

<script>
	import ProfileContainer from '../components/ProfileContainer';
	import ProfessorDetailsCard from '../components/ProfessorDetailsCard';
	import ProfessorReview from '../components/ProfessorReview';

	export default {
		name: 'Professor',
		components: {
			ProfileContainer, ProfessorDetailsCard, ProfessorReview,
		},	
		/**
		 * Fetch the professor's additional data like department and the reviews
		 * @return {Void} 
		 */
		created() {
			setTimeout(() => this.ratingsAreReady = true, 2500);
		},
		data() {
			return {
				renderList: false,
				ratingsAreReady: false,
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
			};
		},
		computed: {
			hasRatings() {
				return this.ratings.length > 0;
			},
			numberOfSimilarProfs() {
				return {
					school: 2,
					department: 7,
				};
			},

			/**
			 * Determine whether the professors' datas are ready to be used
			 * @return {Boolean} 
			 */
			dataIsReady() {
				const {beingFetched, data} = this.$store.state.prof;
				return ! beingFetched && data !== null;
			},

			/**
			 * Search for the professor with the given slug in the app's store
			 * @return {Object|Void} 
			 */
			professor() {
				 const {slug} = this.$route.params;
				 const {data} = this.$store.state.prof;

				 if(this.dataIsReady) {
					return data.find(prof => prof.slug == slug);
				}
			},

			/**
			 * Search for the given professor's school in the app's state
			 * @return {Void} 
			 */
			professorSchool() {
				const {data} = this.$store.state.school;
				const {school_id: id} = this.professor;

				if(this.professor && data) {
					return data.find(school => school.id = id);
				}
			}
		},
		watch: {
			/**
			 * When the data is ready and no professor with the given slug exists then redirect
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady: function(isReady) {
				if(isReady && !this.professor) {
					this.$router.push('/notFound');
				}
			},
		},
	};
</script>

<style scoped>
	.md-title {
		margin: 2em 0;
	}
</style>