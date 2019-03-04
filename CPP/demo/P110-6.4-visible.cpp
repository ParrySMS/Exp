#include <iostream>
using namespace std;

int id =3;
int main(){
	{
		int id = 66;
		cout<<id<<endl;
	}//end id 66
	
	//如果没有大括号包住 块作用域则是整个main函数 -- 则会输出两个66 
	cout<<id<<endl;
	return 0;
}
