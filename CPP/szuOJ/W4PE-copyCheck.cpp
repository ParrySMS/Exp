#include <cstring>
#include <iostream>
#include <algorithm>
using namespace std;

struct paper {
	int stuno;
	char answer1[255];
	char answer2[255];
	char answer3[255];
};



bool isCopy(char a[255],char b[255]) {
//	cout<<"isC"<<endl;

	double simi = 0.0;
	int i;
	for(i=0; i<255; i++) {
		if(a[i]=='\0' || b[i]=='\0') {
			break;
		}

		if(a[i]== b[i]) {
			simi++;
		}
	}

//	cout<<"  isC-len-end"<<endl;
//	cout<<"  simi:"<<simi;
//	cout<<"  i:"<<i;
	return (simi/i)>= 0.9;

}

int main() {
	int t,i,j,n;
	bool isCopy(char a[255],char b[255]) ;
	cin>>t;
	paper *my_paper = new paper[t];
	paper *p = my_paper;
	for(i=0; i<t; i++) {
		cin>> my_paper[i].stuno;
		cin>> my_paper[i].answer1;
		cin>> my_paper[i].answer2;
		cin>> my_paper[i].answer3;
	}

	for(i=0; i<t; i++) {
		for(j=i+1; j<t; j++) {

//			cout<<"pi 1"<<my_paper[i].answer1<<endl;
//			cout<<"pj 1"<<my_paper[j].answer1<<endl;

			if(isCopy(my_paper[i].answer1,my_paper[j].answer1)) {
				cout<<my_paper[i].stuno<<" ";
				cout<<my_paper[j].stuno<<" ";
				cout<<1<<endl;
			}

			if(isCopy(my_paper[i].answer2,my_paper[j].answer2)) {
				cout<<my_paper[i].stuno<<" ";
				cout<<my_paper[j].stuno<<" ";
				cout<<2<<endl;
			}

			if(isCopy(my_paper[i].answer3,my_paper[j].answer3)) {
				cout<<my_paper[i].stuno<<" ";
				cout<<my_paper[j].stuno<<" ";
				cout<<3<<endl;
			}

		}
	}

	delete [] my_paper;

//	isCopy('aaaaaa','aaaaaaa');

	return 0;
}
