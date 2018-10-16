#include <iostream>
#include <string>
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

		void CountLeaf(BinTreeNode* t);



	public:
		int leaf_num;
		BinTree() {
			leaf_num = 0;
		};
		~BinTree() {};
		void CreateTree(string TreeAr);
		bool isVaildCh(char ch);
		void setRoot(BinTreeNode* node);
		void CountLeaf();
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


//private
void BinTree::CountLeaf() {
	CountLeaf(root);
}
//public
void BinTree::CountLeaf(BinTreeNode *t) {
	cout<<"check t:"<<t->data<<endl;
	cout<<"left:"<<t->left<<endl;
	cout<<"right:"<<t->right<<endl;
	
	if(t!=NULL && isVaildCh(t->data)) {
		cout<<"in left"<<endl;
		CountLeaf(t->left);
		
		cout<<"in right"<<endl;
		CountLeaf(t->right);
	}

	if(t->left == NULL && t->right == NULL) {
		cout<<"+"<<endl;
		leaf_num++;
	} else if(!isVaildCh(t->left->data) && !isVaildCh(t->right->data) ) {
		cout<<"++"<<endl;
		leaf_num++;
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
		bin->CountLeaf();
		cout<<bin->leaf_num;

		bin->~BinTree();

	}
	return 0;
}









