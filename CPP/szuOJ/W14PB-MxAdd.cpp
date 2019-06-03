#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Mx {
		int line,col;
		int **data;

	public:
		int getLine() const {
			return line;
		}

		int getCol() const {
			return col;
		}

		int **getDataP() const {
			return data;
		}

		Mx() {}
		Mx(int m,int n) {//包含输入
			int i,j;
			line = m;
			col = n;

			data=new int*[m];  //先创建m行
			for(i=0; i<m; i++) {
				data[i]=new int[n];    //再创建n列
			}
			for (i=0; i<m; i++)
				for (j=0; j<n; j++)
					cin>>data[i][j];
		}

		Mx(const Mx& mx) {
			int i,j;
			line = mx.getLine();
			col = mx.getCol();
			int ** pd = mx.getDataP();
			data=new int*[line];  //先创建m行
			for(i=0; i<line; i++) {
				data[i]=new int[col];    //再创建n列
			}
			for (i=0; i<line; i++)
				for (j=0; j<col; j++)
					data[i][j] = pd[i][j];
		}


		Mx operator +(const Mx& mx) {
			int i,j;
			Mx res(mx);
			int ** pd = res.getDataP();
			for (i=0; i<line; i++)
				for (j=0; j<col; j++)
					pd[i][j] += data[i][j];

			return res;
		}

		void show() {
			int i,j;
			for (i=0; i<line; i++)
				for (j=0; j<col; j++) {
					if(j==col-1) {
						cout<<data[i][j]<<endl;
					} else {
						cout<<data[i][j]<<" ";
					}
				}
		}

};
int main() {
	int i,t,m,n;
	cin>>t;
	while(t--) {
		cin>>m>>n;
		Mx mx1(m,n);
		Mx mx2(m,n);
		Mx res = mx1+mx2;
		res.show();
	}
	return 0 ;
}

