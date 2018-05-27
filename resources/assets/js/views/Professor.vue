<template>
	<ProfileContainer v-if="professor">
		<ProfessorDetailsCard 
			:prof="professor" 
			:school="professor.school"
			:ratings="ratingsAreReady ? ratings : null"
			:numberOfSimilarProfs="numberOfSimilarProfs"
		></ProfessorDetailsCard>
		<div 
			v-if="ratingsAreReady"
			class="md-layout-item md-size-100 md-layout"
		>
			<p v-if="hasRatings" class="md-layout-item md-title md-size-100">Student Reviews</p>
			<p v-else class="noreview-space"></p>
			<form class="md-layout md-layout-item md-size-95 ml-auto mr-auto" @submit.preventDefault="continueReview">
				<md-field class="md-layout-item md-size-70 md-xsmall-size-100">
			      	<label>Write your review:</label>
			     	<md-textarea 
			     		v-model="quickReview"
			     		placeholder="Start typing your comment of this professor here. (You can press ENTER to go to the next line)."
			     		:maxlength="350"
			      		md-autogrow
			    	></md-textarea>
			    </md-field>
			    <md-button 
			    	class="md-raised md-accent md-layout-item"
			    	type="submit"
			    >Continue your review</md-button>
			</form>
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
			     	<md-button class="md-primary md-raised"
			     		:to="{name: 'rateProfessor', 
			     			params:{
			     				id: professor.id,
			     				slug: professor.slug,
			     			}
			     		}"
			     	>Write a review</md-button>
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
			setTimeout(() => this.ratingsAreReady = true, 1500);
		},
		data() {
			return {
				/**
				 * Whether the allow the list of reviews to be shown
				 * @type {Boolean}
				 */
				renderList: false,
				ratingsAreReady: false,
				quickReview: '',
				ratings: [],
				d:[
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
			 * Determine whether the datas for this page are ready to be used
			 * @return {Boolean} 
			 */
			dataIsReady() {
				const isProfReady = () => {
					const {beingFetched, data} = this.$store.state.prof;
					return !beingFetched && data !== null;
				}

				const isSchoolReady = () => {
					const {beingFetched, data} = this.$store.state.school;
					return !beingFetched && data !== null;
				}

				return isProfReady() && isSchoolReady();
			},

			/**
			 * Search for the professor with the given slug in the app's store
			 * @return {Object|Void} 
			 */
			professor() {
				 const {slug} = this.$route.params;
				 const {prof: {data: profs}, school: {data: schools}} = this.$store.state;

				 if(this.dataIsReady) {
					const prof = profs.find(prof => prof.slug == slug);
					prof.school = schools.find(school => school.id == prof.school_id);

					return prof;
				}
			},
		},
		watch: {
			/**
			 * When the data is ready and no professor with the given slug exists then redirect
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady: function(isReady) {
				if(isReady && !this.professor) {
					this.$router.push({name: 'notFound'});
				}
			},
		},
		methods: {
			/**
			 * Save the written review to the store and navigate to full review creation page
			 * @return {Void} 
			 */
			continueReview() {
				const {quickReview: review, professor: {id, slug}} = this;

				this.$store.commit('writeQuickReview', review);
				this.$router.push({name: 'rateProfessor', params: {id, slug}});
			},
		},
	};
</script>

<style scoped>
	.md-title {
		margin: 2em 0;
	}
	.noreview-space {
		margin-top: 2em;
		width: 100%;
	}
</style>