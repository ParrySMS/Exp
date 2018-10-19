#include <iostream>
#include <string>
using namespace std;



bool isHui(string s) {
	int i,j;
	i= 0;
	j = s.length()-1;

	while( (s[i]==s[j]||s[i]+32 ==s[j] ||s[i] ==s[j]+32)&& i<=j) {
		i++;
		j--;
	}

	return  (i>j);

}

int main() {
	string str,substr;
	int start = 0,sublen;

	cin>>str;
	//cut

	for(sublen = str.length(); start<str.length() && sublen>0; sublen--) {


		substr = str.substr(start,sublen);


		if(sublen==1 || isHui(substr)) {
			cout<<substr<<" ";
			start = start + sublen;
			sublen = str.length()- sublen+1;
		}
	}


	return 0;
}

