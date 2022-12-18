// This class contains most of javascript logic of work-with-us-plugin, for ilpost.it.
// It adds a call-to-action after the fourth paragraph of certain posts.
// I guess such plugin may have been implemented with much less javascript logic and relying more  on server implementation, but it would require knowing how "ilpost.it" works under the hood.

class WwupCallToAction {
	// node element of the container
	postContainer=null;
	// number of paragraph after which the box should be inserted
	numberOfParagraphs=4;
	lastParagraph=null;
	// variable used to contain the DOM node containing the call-to-action
	box=null;
	
	contructor(containerIdentifier) {
		this.setContent(content);
		setContainer(containerIdentifier);
		initializeBox();
	}
	
	// if no containerIdentifier is given, it uses the document itself
	setContainer(containerIdentifier) {
		let selector=containerIdentifier || 'body';
		this.postContainer=document.querySelector(selector);
	}
	
	initializeBox() {
		this.box=document.querySelector(".wwup_call_to_action");
	}
	
	// move the box after the 4th paragraph or after the last paragraph if they are less than 4
	appendBox() {
		let paragraphs = this.container.querySelectorAll('p');
		// if there are no paragraphs, the box is inserted at the end of the container
		if (paragraphs.length <= 4) {
			this.container.appendChild(this.box);
		} else {
			let paragraph=paragraphs[4];
			this.container.insertBefore(this.box, paragraph);
		}
	}
}		
		
