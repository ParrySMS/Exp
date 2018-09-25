#include <queue>
#include <iostream>
#include <stdio.h>
using namespace std;

//array index
#define A 0
#define B 1
#define C 2

class Customer {
	public:
		char type;
		int time;
		Customer(char type,int time);
		~Customer();

};

Customer::Customer(char c_type,int c_time) {
	type =  c_type;
	time = c_time;
}



int main() {
	int i,n,avg;
	int sum[3]={0,0,0},len[3]={0,0,0};
	char type;
	int time;


	queue <char>  cq_type;
	queue <int>  cq_time;

	cin>>n;

	for(i=0; i<n; i++) {
		cin>>type;
		cq_type.push(type);
	}

	for(i=0; i<n; i++) {
		cin>>time;
		cq_time.push(time);
	}

	//count

	for(i=0; i<n; i++) {

		if(cq_type.empty() ||cq_time.empty()) {
			break;
		}
		switch(cq_type.front()) {
			case 'A':
				len[A]++;
				sum[A] += cq_time.front();
				break;
			case 'B':
				len[B]++;
				sum[B] += cq_time.front();
				break;
			case 'C':
				len[C]++;
				sum[C] += cq_time.front();
				break;
		}

		cq_type.pop();
		cq_time.pop();
	}

	//output
	
	for(i=0; i<3; i++) {
		avg = sum[i]/len[i];
		
		cout << avg << endl;
	}


	return 0;
}
