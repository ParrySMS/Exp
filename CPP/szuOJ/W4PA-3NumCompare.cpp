#include <string>
#include <iostream>
using namespace std;

void threeSort(int &a,int &b,int &c) {
	int max,min,mid;

	max = a>b?a:b;
	min = a>b?b:a;

	max = c> max? c: max;
	min = c< min? c: min;

//	cout<<"max:"<<max;
//	cout<<"  min:"<<min<<endl;;
	mid = a+b+c - (max) -(min);

	a = max;
	b = mid;
	c = min;

	return;

}

int main() {
	int t,i,a,b,c;
	cin>>t;
	while(t--) {
		cin>>a>>b>>c;
		threeSort(a,b,c);
		cout<<a<<" ";
		cout<<b<<" ";
		cout<<c<<endl;
	}
	return 0;
}
