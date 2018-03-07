<template>
	<md-card class="md-layout-item md-small-size-100 md-medium-size-95 md-size-100 space-below container" md-with-hover>
		<div class="md-layout">
			<md-content class="md-layout-item md-layout text-center md-xsmall-size-25 md-small-size-20 md-size-15">
				<div :class="ratingContainerClass">
					<p :class="ratingLabelClass">Rating</p> 
					<p :class="ratingValueClass">{{rating.overall_rating}}</p>
				</div>

				<div :class="ratingContainerClass">
					<p :class="ratingLabelClass">Difficulty</p> 
					<p :class="ratingValueClass">{{rating.difficulty_rating}}</p>
				</div>
			</md-content>

			<md-content class="md-layout-item md-xsmall-hide md-small-size-20 md-size-20">
				<p>Class: {{rating.class}}</p>
				<br>
				<p class="no-margin"><b>Texbook used:</b> {{textbookWasUsed}}</p>
				<p class="no-margin"><b>Would take again:</b> {{wouldRetakeClass}}</p>
				<p class="no-margin"><b>Grade Received:</b> {{rating.grade_received}}</p>
			</md-content>
			<md-content class="md-layout-item">{{rating.comment}}</md-content>
		</div>
		<div class="md-layout md-alignment-top-right">
			<span class="date"><md-icon>access_time</md-icon> January 1st, 2019 At 8:30am</span>
			<a class="md-layout-item report-link" href="#">Report this rating</a>
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
		},
		data() {
			return {
				ratingContainerClass: 'md-layout-item md-size-80',
				ratingLabelClass: 'md-subtitle',
				ratingValueClass: 'md-headline text-size3',
			};
		},
		computed: {
			textbookWasUsed() {
				return this.rating.textbook_used ? 'Yes' : 'No';
			},
			wouldRetakeClass() {
				return this.rating.would_retake ? 'Yes' : 'No';
			}
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
	.space-below {
		margin-bottom: 1.8em;
	}
	.container {
		padding-top: 2em;
		padding-bottom: 1em;
	}
	.text-size3 {
		font-size: 2.8em;
	}
	.report-link {
		text-align: right;
	}
	.date {
		font-size: .8em;
		opacity: .4;
	}
</style>