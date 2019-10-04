import { Component, AfterViewInit } from '@angular/core';
@Component({
	selector: 'ea-starter',
	templateUrl: './starter.component.html'
})
export class StarterComponent implements AfterViewInit {
	title:string;
	subtitle:string;	
	constructor() {
		this.title = "Starter Page";
		this.subtitle = "This is some text within a card block."
	}

	ngAfterViewInit(){}
}