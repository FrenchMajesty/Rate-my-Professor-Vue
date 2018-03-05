<template>
	<md-card md-with-hover>
		<div :class="'md-layout-item md-layout '+size">
			<md-content class="md-layout-item md-layout md-gutter text-center score-column md-size-20">
				<div :class="ratingContainerClass">
					<p :class="ratingLabelClass">Overall:</p> 
					<p :class="ratingValueClass">{{rating.overall_rating}}</p>
				</div>

				<div :class="ratingContainerClass">
					<p :class="ratingLabelClass">Difficulty:</p> 
					<p :class="ratingValueClass">{{rating.difficulty_rating}}</p>
				</div>
			</md-content>

			<md-content class="md-layout-item"></md-content>
			<md-content class="md-layout-item md-size-70">{{rating.comment}}</md-content>
		</div>
		<div>
			Date, <a href="#">Report this Rating</a>
		</div>
	</md-card>
</template>

<script>
	export default {
		name: 'ProfessorReview',
		props: {
			rating: {
				type: Object,
				required: true,
			},
			size: {
				type: String,
				default: '',
			}
		},
		data() {
			return {
				ratingContainerClass: 'md-layout-item md-size-80',
				ratingLabelClass: 'md-subtitle',
				ratingValueClass: 'md-headline',
			};
		},
	};
</script>

<style scoped>
	.md-subtitle {
		margin: 0;
	}
	.score-column {
		min-height: 11em;
		padding-top: 1em;
	}
</style>