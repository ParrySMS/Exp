#include <iostream>
using namespace std;

int main() {
	long num,count=0,yinshu,low=0,now=0,high=0;

	cin>>num;

	for(yinshu=1; num/yinshu!=0; yinshu=yinshu*10) {
		high = num/(yinshu*10);
		now = (num/yinshu)%10;
		low = num-(num/yinshu)*yinshu;

		if(now == 0) {
			count = count + high*yinshu;

		} else if(now ==1) {
			count = count + high*yinshu + low + 1;

		} else {
			count = count + (high+1)*yinshu;
		}

	}//end for

	cout<<count;

	return 0;
}

