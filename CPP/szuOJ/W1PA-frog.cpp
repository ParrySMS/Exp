#include <iostream>
using namespace std;

int getOverAvgNum(int * weight,int n);

int main() {

	int i,t,n;
	int *weight;

	cin>>t;
	while(t--) {
		cin>>n;
		weight = new int[n]();
		for(i=0; i<n; i++) {
			cin>>weight[i];
		}

		cout<<getOverAvgNum(weight,n)<<endl;
		
		delete [] weight;
	}

	return 0;
}

int getOverAvgNum(int * weight,int n) {
	int i,sum,num;
	float avg;
	for(sum=0,i=0; i<n; i++) {
		sum += weight[i];
	}
	avg = (float)sum/n;

	for(num=0,i=0; i<n; i++) {
		if(weight[i]>avg) {
			num++;
		}
	}
	return num;
}
