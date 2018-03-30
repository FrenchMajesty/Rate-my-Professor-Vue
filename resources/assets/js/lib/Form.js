import Errors from './Errors';

export default class Form {

	/**
	 * Create Form object and initiate object properties
	 * @param  {Object} data The form inputs
	 */
	constructor(data) {

		for(let field in data) {
			this[field] = data[field];
		}

		this.data = data;
		this.errors = new Errors();
	}

	/**
	 * Return the data relevant for the form to submit to server
	 * @return {Object} 
	 */
	getData() {
		let data = {};

		for(let property in this.data) {
			data[property] = this[property];
		}

		return data;
	}
		
	/**
	 * Handle the submit of the form by running the api function
	 * @param  {Function} apiFunction The API function to run for submitting the form
	 * @return {Void}           
	 */
	submit(apiFunction) {
		return new Promise((resolve, reject) => {
			apiFunction(this.getData())
			.then(res => {
				this.onSuccess(res);
				resolve(res);
			})
			.catch(res => {
				this.onFail(res);
				reject(res);
			});
		});
	}

	/**
	 * Clear the form's fields
	 * @param  {Object} res The server's response
	 * @return {Void}     
	 */
	onSuccess(res) {
		this.reset();
	}

	/**
	 * Record the server errors in the Errors object
	 * @param  {Object} res The server's response
	 * @return {Void}     
	 */
	onFail(res) {
		const {errors} = res.response.data;
		this.errors.record(errors);
	}

	/**
	 * Reset the form's field
	 * @return {Void} 
	 */
	reset() {
		for(let field in this.data) {
			this[field] = '';
		}

		this.errors.clear();
	}
}