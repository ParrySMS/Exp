#include <iostream>
#include <string>
#include <queue>
using namespace std;

class BinTreeNode {
	public:
		char data;
		BinTreeNode *left;
		BinTreeNode *right;
		BinTreeNode () {
			left = NULL;
			right = NULL;
		}
		~BinTreeNode();
};


class BinTree {
	private:
		BinTreeNode* root;
		int pos;
		string strTree;
		BinTreeNode * CreateBinTree();
		void LevelOrder(BinTreeNode *left,BinTreeNode *right);


	public:
		queue<BinTreeNode *> tq;
		BinTree() {};

		~BinTree() {
			while(!tq.empty()) {
				tq.pop();
			}
		};
		void CreateTree(string TreeAr);

		void LevelOrder();//²ã´Î
		bool isVaildCh(char ch);
		void setRoot(BinTreeNode* node);

};

void BinTree::setRoot(BinTreeNode* node) {
	root = node;
}

bool BinTree::isVaildCh(char ch) {
	return ch!='0' && ch!='\0';
}

// use PreOrder string to build a tree
void BinTree::CreateTree(string TreeAr) {
	pos = 0;
	strTree.assign(TreeAr);
	root = CreateBinTree();

}


//fill the node by recursion
// PreOrder string
BinTreeNode* BinTree::CreateBinTree() {
	BinTreeNode* t;
	char ch;
	ch = strTree[pos++];//next char
//	cout<<"ch:"<<ch<<endl;

	if(!isVaildCh(ch)) {
		t = NULL;
	} else {
		//	cout<<"new tree node";
		t = new BinTreeNode();
		t->data = ch;
		t->left = CreateBinTree();
		t->right = CreateBinTree();
	}

	return t;
}


//public ²ã´Î
void BinTree::LevelOrder() {
	LevelOrder(root,NULL);
	cout<<endl;
}

//private ²ã´Î
void BinTree::LevelOrder(BinTreeNode *left,BinTreeNode *right) {

	BinTreeNode *p;

	if(left!=NULL && isVaildCh(left->data)) {
		//	cout<<"push left:"<<left->data<<endl;
		tq.push(left);
	}


	if(right!=NULL && isVaildCh(right->data)) {
		//	cout<<"push right:"<<right->data<<endl;
		tq.push(right);
	}


	if(!tq.empty()) {

		p = tq.front();
		if(p!=NULL && isVaildCh(p->data)) {
			//	cout<<"front p:"<<p->data<<endl;
			cout<<p->data;
			tq.pop();
			LevelOrder(p->left,p->right);
		}
	}



}


int main() {
	int t;
	string str;
	BinTree * bin;
	cin>>t;

	while(t--) {

		cin>>str;

		bin = new BinTree();
		bin->CreateTree(str);

		bin->LevelOrder();
	}
	return 0;
}









