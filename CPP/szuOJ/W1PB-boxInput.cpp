#include <iostream>
#include <algorithm>
using namespace std;

void checkMatch(int* box1,int* box2);

int main() {
	int i,t;

	cin>>t;
	while(t--) {
		int *box1 = new int[3];
		int *box2 = new int[3];
		for(i=0; i<3; i++) {
			cin>>box1[i];
		}

		for(i=0; i<3; i++) {
			cin>>box2[i];
		}

		checkMatch(box1,box2);
		delete []box1;
		delete []box2;
	}
	return 0;
}


void checkMatch(int* box1,int* box2) {
	sort(box1,box1+3);
	sort(box2,box2+3);

	if(box1[0]>box2[0]){//make box1 smaller --swap
		int *t;
		t = box1;
		box1 = box2;
		box2 = t;
	}

	int i;
	for(i=0; i<3; i++) {
		if(box1[i]>box2[i]) {
			cout<<"no"<<endl;
			return;
		}
	}

	cout<<"yes"<<endl;

}


